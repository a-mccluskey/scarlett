// <copyright file="MySQLDataSource.cs" company="Scarlett Dot Net">
// Copyright (c) Scarlett Dot Net. All rights reserved.
// </copyright>

namespace ScarNet.DataSources
{
    using System.Collections.Generic;
    using Microsoft.Extensions.Configuration;
    using MySql.Data.MySqlClient;
    using ScarNet.Models;

    public class MySQLDataSource : IDataSource
    {
        private readonly string connectionString;
        private readonly MySqlConnection connection;

        /// <summary>
        /// Initializes a new instance of the <see cref="MySQLDataSource"/> class.
        /// </summary>
        public MySQLDataSource(IConfiguration configuration)
        {
            this.connectionString = configuration.GetConnectionString("DefaultConnection");
            this.connection = new MySqlConnection(this.connectionString);
            //// Initialise the connection
            this.connection.Open();
            _ = this.connection.Ping();
            this.connection.Close();
        }

        /// <inheritdoc />
        Article IDataSource.GetArticleById(int id)
        {
            Article article = null;
            MySqlCommand cmd = new MySqlCommand($"Select * from articles Where art_id = '{id}'", this.connection);
            this.connection.Open();
            using (var reader = cmd.ExecuteReader())
            {
                while (reader.Read())
                {
                    article = new Article(
                        reader.GetString("art_title"),
                        reader.GetString("art_text"),
                        reader.GetDateTime("art_created"),
                        reader.GetDateTime("art_updated"),
                        reader.GetString("art_preview"),
                        reader.GetInt32("art_id"));
                }
            }

            this.connection.Close();
            return article;
        }

        /// <inheritdoc />
        List<Article> IDataSource.GetArticleList()
        {
            var articles = new List<Article>();
            MySqlCommand cmd = new MySqlCommand("Select * from navigation", this.connection);
            this.connection.Open();
            using (var reader = cmd.ExecuteReader())
            {
                while (reader.Read())
                {
                    articles.Add(new Article(
                        reader.GetString("art_title"),
                        reader.GetString("art_text"),
                        reader.GetDateTime("art_created"),
                        reader.GetDateTime("art_updated"),
                        reader.GetString("art_preview"),
                        reader.GetInt32("art_id")));
                }
            }

            this.connection.Close();
            return articles;
        }

        /// <inheritdoc />
        List<Navigation> IDataSource.GetNavigation()
        {
            var navigation = new List<Navigation>();
            MySqlCommand cmd = new MySqlCommand("Select * from navigation", this.connection);
            this.connection.Open();
            using (var reader = cmd.ExecuteReader())
            {
                while (reader.Read())
                {
                    navigation.Add(new Navigation(reader.GetString("nav_text"), reader.GetString("nav_link"), reader.GetInt32("nav_id")));
                }
            }

            this.connection.Close();
            return navigation;
        }
    }
}
