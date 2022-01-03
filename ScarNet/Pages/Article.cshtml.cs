namespace ScarNet.Pages
{
    using Microsoft.AspNetCore.Mvc.RazorPages;
    using Microsoft.Extensions.Logging;

    public class ArticleModel : PageModel
    {
        /// <summary>
        /// The identifier
        /// </summary>
        public int Id;

        private readonly ILogger<GalleryModel> logger;

        /// <summary>
        /// Initializes a new instance of the <see cref="GalleryModel"/> class.
        /// </summary>
        /// <param name="logger">The logger.</param>
        public ArticleModel(ILogger<GalleryModel> logger)
        {
            this.logger = logger;
        }

        /// <summary>
        /// Called when [get].
        /// </summary>
        /// <param name="id">The identifier.</param>
        public void OnGet(int id)
        {
            this.Id = id;
        }
    }
}
