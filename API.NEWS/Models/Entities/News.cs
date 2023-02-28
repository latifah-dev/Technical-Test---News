namespace API.NEWS.Models.Entities
{
    public class News
    {
        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        public int Id { get; set; }
        public string Title {get; set;}
        public string FileName { get; set; }
        public string Url { get; set; }
        public string Content {get; set;}
    }
}