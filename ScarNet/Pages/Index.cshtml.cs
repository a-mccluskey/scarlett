// <copyright file="Index.cshtml.cs" company="Scarlett Dot Net">
// Copyright (c) Scarlett Dot Net. All rights reserved.
// </copyright>

namespace ScarNet.Pages
{
    using Microsoft.AspNetCore.Mvc.RazorPages;
    using Microsoft.Extensions.Logging;

    /// <summary>
    /// Index model.
    /// </summary>
    /// <seealso cref="Microsoft.AspNetCore.Mvc.RazorPages.PageModel" />
    public class Index : PageModel
    {
        private readonly ILogger<Index> logger;

        /// <summary>
        /// Initializes a new instance of the <see cref="IndexModel"/> class.
        /// </summary>
        /// <param name="logger">The logger.</param>
        public Index(ILogger<Index> logger)
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
