namespace ScarNet.Pages
{
    using Microsoft.AspNetCore.Mvc.RazorPages;
    using Microsoft.Extensions.Logging;

    public class ArticleModel : PageModel
    {
        private readonly ILogger<GalleryModel> logger;
        public int id;

        /// <summary>
        /// Initializes a new instance of the <see cref="GalleryModel"/> class.
        /// </summary>
        /// <param name="logger">The logger.</param>
        public ArticleModel(ILogger<GalleryModel> logger)
        {
            this.logger = logger;
        }

        public void OnGet(int id)
        {
            this.id = id;
        }
    }
}
