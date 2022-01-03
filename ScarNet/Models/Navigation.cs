// <copyright file="Navigation.cs" company="Scarlett Dot Net">
// Copyright (c) Scarlett Dot Net. All rights reserved.
// </copyright>

namespace ScarNet.Models
{
    /// <summary>
    /// Navigation elements.
    /// </summary>
    public class Navigation
    {
        /// <summary>
        /// Initializes a new instance of the <see cref="Navigation"/> class.
        /// </summary>
        /// <param name="title">The title.</param>
        /// <param name="location">The location.</param>
        /// <param name="id">The identifier.</param>
        public Navigation(string title, string location, int id)
        {
            this.Title = title;
            if (location != null && location.Contains("Article/"))
            {
                this.ArticleID = location.Replace("/Article/", string.Empty).Replace("Article/", string.Empty);
                this.Location = location.Replace("/" + this.ArticleID, string.Empty);
            }
            else
            {
                this.Location = location;
                this.ArticleID = string.Empty;
            }

            this.Id = id;
        }

        /// <summary>
        /// The title.
        /// </summary>
        public string Title { get; set; }

        /// <summary>
        /// The location.
        /// </summary>
        public string Location { get; set; }

        /// <summary>
        /// Gets or sets the article identifier.
        /// </summary>
        /// <value>
        /// The article identifier.
        /// </value>
        public string ArticleID { get; set; }

        private int Id { get; }
    }
}
