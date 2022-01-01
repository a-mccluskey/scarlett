// <copyright file="NavigationService.cs" company="Scarlett Dot Net">
// Copyright (c) Scarlett Dot Net. All rights reserved.
// </copyright>

namespace ScarNet.Services
{
    using System.Collections.Generic;
    using ScarNet.DataSources;
    using ScarNet.Models;
    using ScarNet.Services.IServices;

    /// <summary>
    /// Navigation Service
    /// </summary>
    /// <seealso cref="ScarNet.Services.IServices.INavigationService" />
    public class NavigationService : INavigationService
    {
        private readonly IDataSource dataSource;

        /// <summary>
        /// Initializes a new instance of the <see cref="NavigationService"/> class.
        /// </summary>
        public NavigationService()
        {
        }

        public NavigationService(IDataSource dataSource)
        {
            this.dataSource = dataSource;
        }

        /// <inheritdoc />
        public List<Navigation> GetNavigations()
        {
            return this.dataSource.GetNavigation();
        }
    }
}
