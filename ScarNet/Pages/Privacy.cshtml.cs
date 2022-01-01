// <copyright file="Privacy.cshtml.cs" company="Scarlett Dot Net">
// Copyright (c) Scarlett Dot Net. All rights reserved.
// </copyright>

namespace ScarNet.Pages
{
    using Microsoft.AspNetCore.Mvc.RazorPages;
    using Microsoft.Extensions.Logging;

    /// <summary>
    /// Privacy Model.
    /// </summary>
    /// <seealso cref="Microsoft.AspNetCore.Mvc.RazorPages.PageModel" />
    public class PrivacyModel : PageModel
    {
        private readonly ILogger<PrivacyModel> logger;

        /// <summary>
        /// Initializes a new instance of the <see cref="PrivacyModel"/> class.
        /// </summary>
        /// <param name="logger">The logger.</param>
        public PrivacyModel(ILogger<PrivacyModel> logger)
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
