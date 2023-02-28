namespace API.NEWS.Controllers
{
    [ApiController]
    [Route("api/[controller]")]
    public class AuthController : ControllerBase
    {
        private readonly ApplicationDbContext _dbContext;
        private readonly IEmailService _emailservice;
        public AuthController(ApplicationDbContext dbContext, IEmailService emailservice) {
            _dbContext = dbContext;
            _emailservice = emailservice;
        }

        [HttpPost]
        [Route("register")]
        public async Task<IActionResult> Register(UserDto register) {
            //validasi users
            if(_dbContext.Users.Any(u => u.Email == register.Email)) {
                return BadRequest("Users already axists.");
            }
            //hash password
            var PasswordHasher = new PasswordHasher<string>();
            var hash = PasswordHasher.HashPassword(register.Email, register.Password);
            //create token
            var randomToken = Convert.ToHexString(RandomNumberGenerator.GetBytes(64));
            //create new data to database
            var NewUser = new User() {
                Email = register.Email,
                Password = hash,
                VerificationToken = randomToken,
            };
            //save to database
            _dbContext.Users.Add(NewUser);
            await _dbContext.SaveChangesAsync();
            //send email 
            var email  = new EmailDto() {
                To = register.Email,
                Subject = "VERIFICATION EMAIL",
                Body = "<br/><br/>We are excited to tell you that your account is" +  
      " successfully created. Please input this code to verify your account" +  
      " <br/><br/>code : " + randomToken + "<br/><br/> Thank you. ",
            };
            _emailservice.SendEmail(email);
            //response
            return Created("Register successly, check your email to verification !", NewUser);
        }

        [HttpPost]
        [Route("login")]
        public async Task<IActionResult> Login(UserDto login) {
            //find user
            var user = _dbContext.Users.FirstOrDefault(x => x.Email == login.Email);
            //validasi users is ready
            if(user == null) {
                return Unauthorized("User does not exist");
            }
            //verify password hash
            var PasswordHasher = new PasswordHasher<string>();
            var verifPass = PasswordHasher.VerifyHashedPassword(login.Email, user.Password, login.Password);
            if(verifPass == PasswordVerificationResult.Failed) {
                return BadRequest("Incorrect password");
            }
            //validasi users is verified
            if(user.VerifiedAt == null) {
                return BadRequest("not verified !");
            }
            // definisikan klaim
            var claims = new List<Claim>
            {
                new Claim("sub", user.Id.ToString()), // sub (subject) adalah claim yang umum digunakan untuk menyatakan ID pengguna
                new Claim("email", user.Email), // contoh klaim email
            };
            // create jwt
            var secureKey = "this is very secure key";
            var symmetric = new SymmetricSecurityKey(Encoding.UTF8.GetBytes(secureKey));
            var credentials = new SigningCredentials(symmetric, SecurityAlgorithms.HmacSha256Signature);
            var header = new JwtHeader(credentials);
            var payload = new JwtPayload (null, null, claims, null, DateTime.Today.AddDays(1));
            var securityToken = new JwtSecurityToken(header, payload);
            var token = new JwtSecurityTokenHandler().WriteToken(securityToken);
            //response
            return Ok(new TokenDto {
                Message = $"Welcome back, {user.Email}",
                Access_Token = token,
                Token_Type = "Bearer",
                Expires = DateTime.UtcNow.AddDays(1),
            });
        }
        
        [HttpPost]
        [Route("verify")]
        public async Task<IActionResult> Verify(String token) {
            //find user
            var user = _dbContext.Users.FirstOrDefault(x => x.VerificationToken == token);
            //validasi user
            if(user == null) {
                return BadRequest("User does not exist");
            }
            //update date verified
            user.VerifiedAt = DateTime.UtcNow;
            await _dbContext.SaveChangesAsync();
            //response
            return Ok("user verified :)");
        }
        
        [HttpPost]
        [Route("forgot-password")]
        public async Task<IActionResult> ForgotPassword(String email) {
            //find user
            var user = _dbContext.Users.FirstOrDefault(x => x.Email== email);
            if(user == null) {
                return BadRequest("User does not exist");
            }
            //create random token
             var randomToken = Convert.ToHexString(RandomNumberGenerator.GetBytes(64));
            user.PasswordResetToken = randomToken;
            user.ResetTokenExpires = DateTime.UtcNow.AddDays(1);
            await _dbContext.SaveChangesAsync();
            
            //send email 
            var sendEmail  = new EmailDto() {
                To = email,
                Subject = "FORGOT PASSWORD",
                Body = "<br/><br/>Input the code below to reset your account password." +  
      "  If you didn't request a new password, you can safely delete this email." +  
      " <br/><br/>code : " + randomToken + "<br/><br/> Thank you. ",
            };
            _emailservice.SendEmail(sendEmail);
            return Ok("you may reset your token now");
        }
        
        [HttpPost]
        [Route("reset-password")]
        public async Task<IActionResult> ResetPassword(ResetPasswordDto reset) {
            //find user
            var user = _dbContext.Users.FirstOrDefault(x => x.PasswordResetToken == reset.Token);
            if(user == null || user.ResetTokenExpires < DateTime.UtcNow) {
                return BadRequest("Invalid Token");
            }
            //hash password
            var PasswordHasher = new PasswordHasher<string>();
            var hash = PasswordHasher.HashPassword(user.Email, reset.VerifyPassword);
            
            user.Password = hash;
            user.PasswordResetToken = null;
            user.ResetTokenExpires = null;
            await _dbContext.SaveChangesAsync();
            return Ok("Password successly reset");
        }
        
        [HttpPut]
        [Authorize]
        [Route("change-password")]
        public async Task<IActionResult> ChangePassword(PasswordDto pass) {
            var user = HttpContext.User;
            var Email = user.FindFirst(ClaimTypes.Email)?.Value;
            var currentUser = _dbContext.Users.FirstOrDefault(x => x.Email == Email);
            //verify password hash
            var PasswordHasher = new PasswordHasher<string>();
            var verifPass = PasswordHasher.VerifyHashedPassword(Email, currentUser.Password, pass.OldPassword);
            if(verifPass == PasswordVerificationResult.Failed) {
                return BadRequest("Incorrect old password");
            }
            //hash password
            var hash = PasswordHasher.HashPassword(currentUser.Email, pass.VerifyPassword);
            currentUser.Password = hash;
            await _dbContext.SaveChangesAsync();
            return Ok("Password Has been changed");
        }

        [HttpPost]
        [Route("email")]
        public IActionResult SendEmail(EmailDto request)
        {
            _emailservice.SendEmail(request);
            return Ok();
        }
    }
}