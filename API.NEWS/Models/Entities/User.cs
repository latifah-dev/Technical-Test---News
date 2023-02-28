namespace API.NEWS.Models.Entities
{
    public class User
    {
        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        public int Id { get; set; }
        public string Email {get; set;}
        public string Password {get; set;}
        public string? VerificationToken {get; set;}
        public DateTime? VerifiedAt {get; set;}
        public string? PasswordResetToken {get; set;}
        public DateTime? ResetTokenExpires {get; set;}
    }
}