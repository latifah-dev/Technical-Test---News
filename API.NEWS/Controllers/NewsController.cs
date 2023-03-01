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
                return BadRequest(new {
                status = false,
                message = "news is empty, create data first. ",
                data = new {}
                });
            }
            return Ok(new {
                status = true,
                message = "this news list.",
                data = news
                });
        }

        [HttpGet]
        [Authorize]
        [Route("detail-news")]
        public async Task<IActionResult> detailNews(int id) {
            var news = await _dbContext.News.FindAsync(id);
            if(news == null) {
                return BadRequest(new {
                status = false,
                message = $"news dengan id {id} tidak ada",
                data = new {}
                });
            }
            return Ok(new {
                status = true,
                message = $"news detail {id}",
                data = news
                });
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
            return Ok(new {
                status = true,
                message = "news has been created !",
                data = newNews
                });
        }

        [HttpPost]
        [Authorize]
        [Route("update-news")]
        public async Task<IActionResult> UpdateNews(int id, [FromForm] NewsDto update)
        {
            var uploadImage = Path.Combine(Directory.GetCurrentDirectory(), "wwwroot", "Image");
            if (!Directory.Exists(uploadImage))
                Directory.CreateDirectory(uploadImage);

            var news = await _dbContext.News.FindAsync(id);
            if (news == null)
            {
                return NotFound();
            }

            if (update.FileImage == null)
            {
                // Jika input file kosong, gunakan data yang sudah ada sebelumnya
                news.Title = update.Title;
                news.Content = update.Content;
                news.PublishDate = (DateTime)update.PublishDate;
            }
            else
            {
                // Jika input file tidak kosong, hapus file lama dan gunakan data baru
                var fileImage = $"{update.Title}-{update.FileImage.FileName}";
                var filePath = Path.Combine(uploadImage, fileImage);

                using var stream = System.IO.File.Create(filePath);
                update.FileImage.CopyTo(stream);

                var url = $"{Request.Scheme}://{Request.Host}{Request.PathBase}/Image/{fileImage}";

                // Hapus file lama
                var oldFilePath = Path.Combine(uploadImage, news.FileName);
                if (System.IO.File.Exists(oldFilePath))
                    System.IO.File.Delete(oldFilePath);

                news.Title = update.Title;
                news.FileName = fileImage;
                news.Url = url;
                news.Content = update.Content;
                news.PublishDate = (DateTime)update.PublishDate;
            }

            _dbContext.News.Update(news);
            await _dbContext.SaveChangesAsync();
            return Ok(new
            {
                status = true,
                message = "News has been updated!",
                data = news
            });
        }


        [HttpPost]
        [Authorize]
        [Route("delete-news")]
        public async Task<IActionResult> DeleteNews (int Id) {
            var news = _dbContext.News.First( x => x.Id == Id);

            _dbContext.News.Remove(news);
            await _dbContext.SaveChangesAsync();
            return Ok(new {
                status = true,
                message = "news has been deleted !",
                data = new {}
                });
        }
    }
}