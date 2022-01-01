// <copyright file="INavigationService.cs" company="Scarlett Dot Net">
// Copyright (c) Scarlett Dot Net. All rights reserved.
// </copyright>

namespace ScarNet.Services.IServices
{
    using System.Collections.Generic;
    using ScarNet.Models;

    /// <summary>
    /// The INavigationService Interface.
    /// </summary>
    interface INavigationService
    {
        /// <summary>
        /// Gets the navigation.
        /// </summary>
        /// <returns>Returns list of Navigation</returns>
        List<Navigation> GetNavigations();
    }
}
