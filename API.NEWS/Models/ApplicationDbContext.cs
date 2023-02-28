namespace API.NEWS.Models
{
    public class ApplicationDbContext:DbContext
    {
        public ApplicationDbContext(DbContextOptions<ApplicationDbContext>options):base(options) {
            
        }
        public DbSet<User>Users{get; set;}
        public DbSet<News>News{get;set;}
    }
}