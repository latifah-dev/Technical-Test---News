using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace API.NEWS.Services.EmailService
{
    public interface IEmailService
    {
        void SendEmail(EmailDto request);
    }
}