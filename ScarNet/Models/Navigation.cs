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

        public Navigation(string Title, string Location, int Id)
        {
            this.Title = Title;
            if (Location != null && Location.Contains("Article/"))
            {
                ArticleID = Location.Replace("/Article/", string.Empty).Replace("Article/", string.Empty);
                this.Location = Location.Replace("/" + ArticleID, string.Empty);
            }
            else
            {
                this.Location = Location;
                ArticleID = string.Empty;
            }
            this.Id = Id;
        }
    }
}
