// <copyright file="Article.cshtml.cs" company="Scarlett Dot Net">
// Copyright (c) Scarlett Dot Net. All rights reserved.
// </copyright>
namespace ScarNet.Pages
{
    using Microsoft.AspNetCore.Mvc.RazorPages;
    using Microsoft.Extensions.Logging;

    public class Article : PageModel
    {
        /// <summary>
        /// The identifier
        /// </summary>
        public int Id;

        private readonly ILogger<Article> logger;

        /// <summary>
        /// Initializes a new instance of the <see cref="GalleryModel"/> class.
        /// </summary>
        /// <param name="logger">The logger.</param>
        public Article(ILogger<Article> logger)
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
