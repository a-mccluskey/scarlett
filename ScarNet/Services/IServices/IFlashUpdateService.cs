// <copyright file="IFlashUpdateService.cs" company="Scarlett Dot Net">
// Copyright (c) Scarlett Dot Net. All rights reserved.
// </copyright>
namespace ScarNet.Services.IServices
{
    using System.Collections.Generic;
    using ScarNet.Models;

    /// <summary>
    /// The IFlashUpdateService
    /// </summary>
    interface IFlashUpdateService
    {
        /// <summary>
        /// Gets the flash updates range.
        /// </summary>
        /// <param name="from">From.</param>
        /// <param name="to">To.</param>
        /// <returns>Returns list of flash updates</returns>
        List<FlashUpdate> GetFlashUpdatesRange(int from, int to);

        /// <summary>
        /// Gets the latest flash updates.
        /// </summary>
        /// <param name="updateCount">The update count (default 5).</param>
        /// <returns>Returns latest flash updates (default 5).</returns>
        List<FlashUpdate> GetLatestFlashUpdates(int updateCount = 5);

        /// <summary>
        /// Gets the flash update count.
        /// </summary>
        /// <returns>Returns the total number of flash updates.</returns>
        int GetFlashUpdateCount();
    }
}
