using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace API.NEWS.Models.Dtos
{
    public class PasswordDto
    {
        public string OldPassword {get; set;}
        public string PasswordNew {get; set;}
        [Required, Compare("PasswordNew")]
        public string VerifyPassword {get; set;}
    }
}