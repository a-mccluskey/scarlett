// <copyright file="MySQLDataSource.cs" company="Scarlett Dot Net">
// Copyright (c) Scarlett Dot Net. All rights reserved.
// </copyright>

namespace ScarNet.DataSources
{
    using System;
    using System.Collections.Generic;
    using Microsoft.Extensions.Configuration;
    using MySql.Data.MySqlClient;
    using ScarNet.Models;

    public class MySQLDataSource : IDataSource
    {
        private readonly string ConnectionString;
        private readonly MySqlConnection connection;

        /// <summary>
        /// Initializes a new instance of the <see cref="MySQLDataSource"/> class.
        /// </summary>
        public MySQLDataSource(IConfiguration configuration)
        {
            this.ConnectionString = configuration.GetConnectionString("DefaultConnection");
            this.connection = new MySqlConnection(this.ConnectionString);
        }

        /// <inheritdoc />
        Article IDataSource.GetArticleById(int id)
        {
            throw new NotImplementedException();
        }

        /// <inheritdoc />
        List<Article> IDataSource.GetArticleList()
        {
            throw new NotImplementedException();
        }

        /// <inheritdoc />
        List<Navigation> IDataSource.GetNavigation()
        {
            var navigation = new List<Navigation>();
            using (this.connection)
            {
                this.connection.Open();
                MySqlCommand cmd = new MySqlCommand("Select * from navigation", this.connection);
                using (var reader = cmd.ExecuteReader())
                {
                    while (reader.Read())
                    {
                        navigation.Add(new Navigation(reader.GetString("nav_text"), reader.GetString("nav_link"), reader.GetInt32("nav_id")));
                    }
                }
            }

            return navigation;
        }
    }
}
