// <copyright file="INavigationService.cs" company="Scarlett Dot Net">
// Copyright (c) Scarlett Dot Net. All rights reserved.
// </copyright>

namespace ScarNet.Services.IServices
{
    using System.Collections.Generic;
    using ScarNet.Models;

    /// <summary>
    /// The IArticleService Interface.
    /// </summary>
    interface IArticleService
    {
        /// <summary>
        /// Gets the articles.
        /// </summary>
        /// <returns>Returns the list of articles</returns>
        List<Article> GetArticles();

        /// <summary>
        /// Gets the article by identifier.
        /// </summary>
        /// <param name="id">The identifier.</param>
        /// <returns>Returns a specific article</returns>
        Article GetArticleById(int id);
    }
}
