namespace API.NEWS.Models.Dtos
{
    public class NewsDto
    {
        public string Title { get; set; }
        public string Content { get; set; }
        public DateTime PublishDate { get; set; }
        public IFormFile? FileImage { get; set; }
    }
}