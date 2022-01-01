// <copyright file="IDataSource.cs" company="Scarlett Dot Net">
// Copyright (c) Scarlett Dot Net. All rights reserved.
// </copyright>

namespace ScarNet.DataSources
{
    using System.Collections.Generic;
    using ScarNet.Models;

    /// <summary>
    /// IDataSource Interface.
    /// </summary>
    public interface IDataSource
    {
        /// <summary>
        /// Gets the list of articles.
        /// </summary>
        /// <returns></returns>
        List<Article> GetArticleList();

        /// <summary>
        /// Gets the article by identifier.
        /// </summary>
        /// <param name="id">The identifier.</param>
        /// <returns></returns>
        Article GetArticleById(int id);

        /// <summary>
        /// Gets the navigation.
        /// </summary>
        /// <returns></returns>
        List<Navigation> GetNavigation();
    }
}
