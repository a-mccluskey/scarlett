// <copyright file="Error.cshtml.cs" company="Scarlett Dot Net">
// Copyright (c) Scarlett Dot Net. All rights reserved.
// </copyright>

namespace ScarNet.Pages
{
    using System.Diagnostics;
    using Microsoft.AspNetCore.Mvc;
    using Microsoft.AspNetCore.Mvc.RazorPages;
    using Microsoft.Extensions.Logging;

    /// <summary>
    ///   <br />
    /// </summary>
    [ResponseCache(Duration = 0, Location = ResponseCacheLocation.None, NoStore = true)]
    [IgnoreAntiforgeryToken]
    public class Error : PageModel
    {
        private readonly ILogger<Error> logger;

        /// <summary>
        /// Initializes a new instance of the <see cref="ErrorModel"/> class.
        /// </summary>
        /// <param name="logger">The logger.</param>
        public Error(ILogger<Error> logger)
        {
            this.logger = logger;
        }

        /// <summary>Gets or sets the request identifier.</summary>
        /// <value>The request identifier.</value>
        public string RequestId { get; set; }

        /// <summary>Gets a value indicating whether [show request identifier].</summary>
        /// <value>
        ///   <c>true</c> if [show request identifier]; otherwise, <c>false</c>.</value>
        public bool ShowRequestId => !string.IsNullOrEmpty(this.RequestId);

        /// <summary>
        /// Called when [get].
        /// </summary>
        public void OnGet()
        {
            this.RequestId = Activity.Current?.Id ?? this.HttpContext.TraceIdentifier;
        }
    }
}
