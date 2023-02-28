using System;
using Microsoft.EntityFrameworkCore.Migrations;

#nullable disable

namespace API.NEWS.Migrations
{
    /// <inheritdoc />
    public partial class datenews : Migration
    {
        /// <inheritdoc />
        protected override void Up(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.AddColumn<DateTime>(
                name: "PublishDate",
                table: "News",
                type: "timestamp with time zone",
                nullable: true);
        }

        /// <inheritdoc />
        protected override void Down(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropColumn(
                name: "PublishDate",
                table: "News");
        }
    }
}
