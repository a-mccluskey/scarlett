// <copyright file="Gallery.cshtml.cs" company="Scarlett Dot Net">
// Copyright (c) Scarlett Dot Net. All rights reserved.
// </copyright>
namespace ScarNet.Pages
{
    using Microsoft.AspNetCore.Mvc.RazorPages;
    using Microsoft.Extensions.Logging;

    public class Gallery : PageModel
    {
        private readonly ILogger<Gallery> logger;

        /// <summary>
        /// Initializes a new instance of the <see cref="GalleryModel"/> class.
        /// </summary>
        /// <param name="logger">The logger.</param>
        public Gallery(ILogger<Gallery> logger)
        {
            this.logger = logger;
        }

        /// <summary>
        /// Called when [get].
        /// </summary>
        public void OnGet()
        {
        }
    }
}
