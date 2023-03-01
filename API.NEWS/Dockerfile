# Build stage
FROM mcr.microsoft.com/dotnet/sdk:7.0 AS build
WORKDIR /src
COPY ["API.NEWS.csproj", "."]
RUN dotnet restore "./API.NEWS.csproj"
COPY . .
WORKDIR "/src/."
RUN dotnet build "API.NEWS.csproj" -c Release -o /app/build

# Publish stage
FROM build AS publish
RUN dotnet publish "API.NEWS.csproj" -c Release -o /app/publish

# Runtime stage
FROM mcr.microsoft.com/dotnet/aspnet:7.0 AS runtime
WORKDIR /app
COPY --from=publish /app/publish .
EXPOSE 5139
ENTRYPOINT ["dotnet", "API.NEWS.dll"]

# Database stage
FROM postgres:latest AS database
ENV POSTGRES_USER postgres
ENV POSTGRES_PASSWORD 12345678
ENV POSTGRES_DB NewsDbDotnet
COPY create-db.sql /docker-entrypoint-initdb.d/
EXPOSE 5432

# Swagger stage
FROM swaggerapi/swagger-ui AS swagger
CMD ["dotnet", "API.NEWS.dll"]
