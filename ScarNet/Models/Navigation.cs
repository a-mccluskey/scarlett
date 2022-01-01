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

        private int Id { get; }

        public Navigation(string Title, string Location, int Id)
        {
            this.Title = Title;
            this.Location = Location;
            this.Id = Id;
        }
    }
}
