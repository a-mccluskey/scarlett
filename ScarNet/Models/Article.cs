// <copyright file="Navigation.cs" company="Scarlett Dot Net">
// Copyright (c) Scarlett Dot Net. All rights reserved.
// </copyright>

namespace ScarNet.Models
{
    using System;

    public class Article
    {
        /// <summary>
        /// Initializes a new instance of the <see cref="Article"/> class.
        /// </summary>
        /// <param name="title">The title.</param>
        /// <param name="text">The text.</param>
        /// <param name="updated">The updated.</param>
        /// <param name="created">The created.</param>
        /// <param name="preview">The preview.</param>
        /// <param name="id">The identifier.</param>
        public Article(string title, string text, DateTime updated, DateTime created, string preview, int id)
        {
            this.Title = title;
            this.Text = text;
            this.Updated = updated;
            this.Created = created;
            this.Preview = preview;
            this.Id = id;
        }

        /// <summary>
        /// The title.
        /// </summary>
        public string Title { get; set; }

        /// <summary>
        /// Gets or sets the preview.
        /// </summary>
        /// <value>
        /// The preview.
        /// </value>
        public string Preview { get; set; }

        /// <summary>
        /// Gets or sets the text.
        /// </summary>
        /// <value>
        /// The text.
        /// </value>
        public string Text { get; set; }

        /// <summary>
        /// Gets the created.
        /// </summary>
        /// <value>
        /// The created.
        /// </value>
        public DateTime Created { get; }

        /// <summary>
        /// Gets or sets the updated.
        /// </summary>
        /// <value>
        /// The updated.
        /// </value>
        public DateTime Updated { get; set; }

        /// <summary>
        /// Gets or sets a value indicating whether this <see cref="Article"/> is published.
        /// </summary>
        /// <value>
        ///   <c>true</c> if published; otherwise, <c>false</c>.
        /// </value>
        public bool Published { get; set; }

        /// <summary>
        /// Gets or sets the view count.
        /// </summary>
        /// <value>
        /// The view count.
        /// </value>
        public int ViewCount { get; set; }

        private int Id { get; }
    }
}
