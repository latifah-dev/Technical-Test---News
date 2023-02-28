using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;

namespace API.NEWS.Controllers
{
    [ApiController]
    [Route("api/[controller]")]
    public class NewsController : ControllerBase
    {
        private readonly ApplicationDbContext _dbContext;
        public NewsController (ApplicationDbContext dbContext) {
            _dbContext = dbContext;
        }
        
        [HttpGet]
        [Authorize]
        [Route("show-news")]
        public async Task<IActionResult> showNews() {
            var news = await _dbContext.News.ToListAsync();
            if (news.Count  == 0) {
                return BadRequest("data article kosong");
            }
            return Ok(news);
        }

        [HttpGet]
        [Authorize]
        [Route("detail-news")]
        public async Task<IActionResult> detailNews(int id) {
            var news = await _dbContext.News.FindAsync(id);
            if(news == null) {
                return BadRequest($"news dengan id {id} tidak ada");
            }
            return Ok(news);
        }

        [HttpPost]
        [Authorize]
        [Route("create-news")]
        public async Task<IActionResult> createNews([FromForm] NewsDto create) {
            var uploadImage = Path.Combine(Directory.GetCurrentDirectory(), "wwwroot", "Image");
            if(!Directory.Exists(uploadImage))
                Directory.CreateDirectory(uploadImage);
            
            var fileImage = $"{create.Title}-{create.FileImage.FileName}";
            var filePath = Path.Combine(uploadImage, fileImage);

            using var stream = System.IO.File.Create(filePath);
            if(create.FileImage != null)
                create.FileImage.CopyTo(stream);
            
            var url = $"{Request.Scheme}://{Request.Host}{Request.PathBase}/Image/{fileImage}";
             var newNews = new News
            {
                Title = create.Title,
                FileName = fileImage,
                Url = url,
                Content = create.Content,
                PublishDate = (DateTime)create.PublishDate,
            };
                _dbContext.Add(newNews);
                await _dbContext.SaveChangesAsync();
            return Ok(newNews);
        }

        [HttpPut]
        [Authorize]
        [Route("update-news")]
        public async Task<IActionResult> updateNews(int Id,[FromForm] NewsDto update) {
            var uploadImage = Path.Combine(Directory.GetCurrentDirectory(), "wwwroot", "Image");
            if(!Directory.Exists(uploadImage))
                Directory.CreateDirectory(uploadImage);
            
            var fileImage = $"{update.Title}-{update.FileImage.FileName}";
            var filePath = Path.Combine(uploadImage, fileImage);

            using var stream = System.IO.File.Create(filePath);
            if(update.FileImage != null)
                update.FileImage.CopyTo(stream);
            
            var url = $"{Request.Scheme}://{Request.Host}{Request.PathBase}/Image/{fileImage}";

            var news = _dbContext.News.FirstOrDefault(x => x.Id == Id);
            var Delete = Path.Combine(uploadImage, news.FileName);
            System.IO.File.Delete(Delete);

            news.Title = update.Title;
            news.FileName = fileImage;
            news.Url = url;
            news.Content = update.Content;
            news.PublishDate = (DateTime)update.PublishDate;

            _dbContext.News.Update(news);
            await _dbContext.SaveChangesAsync();
            return Ok(update);
        }

        [HttpDelete]
        [Authorize]
        [Route("delete-news")]
        public async Task<IActionResult> DeleteNews (int Id) {
            var news = _dbContext.News.First( x => x.Id == Id);

            _dbContext.News.Remove(news);
            await _dbContext.SaveChangesAsync();
            return Ok("news has been deleted !");
        }
    }
}