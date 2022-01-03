// <copyright file="ArticleService.cs" company="Scarlett Dot Net">
// Copyright (c) Scarlett Dot Net. All rights reserved.
// </copyright>

namespace ScarNet.Services
{
    using System.Collections.Generic;
    using ScarNet.DataSources;
    using ScarNet.Models;
    using ScarNet.Services.IServices;

    /// <summary>
    /// Article Service
    /// </summary>
    public class ArticleService : IArticleService
    {
        private readonly IDataSource dataSource;

        /// <summary>
        /// Initializes a new instance of the <see cref="NavigationService"/> class.
        /// </summary>
        public ArticleService()
        {
        }

        /// <summary>
        /// Initializes a new instance of the <see cref="ArticleService"/> class.
        /// </summary>
        /// <param name="dataSource">The data source.</param>
        public ArticleService(IDataSource dataSource)
        {
            this.dataSource = dataSource;
        }

        /// <inheritdoc />
        public Article GetArticleById(int id)
        {
            return this.dataSource.GetArticleById(id);
        }

        /// <inheritdoc />
        public List<Article> GetArticles()
        {
            return this.dataSource.GetArticleList();
        }
    }
}
