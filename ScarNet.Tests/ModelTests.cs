using Microsoft.VisualStudio.TestTools.UnitTesting;
using ScarNet.Models;
using System;

namespace ScarNet.Tests
{
    [TestClass]
    public class ModelTests
    {
        [TestMethod]
        public void ArticleTest1()
        {
            //// Setup
            string title = "Test Title";
            string text = "Article Text";
            DateTime updated = new DateTime();
            DateTime created = new DateTime();
            string preview = "Preview Text";
            int id = 0;

            //// Act
            var sut = new Article(title, text, updated, created, preview, id);

            ////Assert
            Assert.AreEqual(sut.Title, title);
            Assert.AreEqual(sut.Text, text);
            Assert.AreEqual(sut.Updated, updated);
            Assert.AreEqual(sut.Created, created);
        }
    }
}
