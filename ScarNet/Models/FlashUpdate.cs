// <copyright file="FlashUpdate.cs" company="Scarlett Dot Net">
// Copyright (c) Scarlett Dot Net. All rights reserved.
// </copyright>
namespace ScarNet.Models
{
    using System;

    /// <summary>
    /// Flash Updates.
    /// </summary>
    public class FlashUpdate
    {
        /// <summary>
        /// The text
        /// </summary>
        public string Text;

        /// <summary>
        /// The location
        /// </summary>
        public string Location;

        /// <summary>
        /// The date created
        /// </summary>
        public DateTime DateCreated;

        private readonly int id;

        /// <summary>
        /// Initializes a new instance of the <see cref="FlashUpdate"/> class.
        /// </summary>
        /// <param name="Text">The text.</param>
        /// <param name="Location">The location.</param>
        /// <param name="DateCreated">The date created.</param>
        /// <param name="id">The identifier.</param>
        public FlashUpdate(string text, string location, DateTime dateCreated, int id)
        {
            this.Text = text;
            this.Location = location;
            this.DateCreated = dateCreated;
            this.id = id;
        }
    }
}
