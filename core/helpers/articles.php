<?php

declare(strict_types=1);

if (!function_exists('get_articles_list')) {
    /**
     * Retourne la liste des articles publiés pour la page blog publique.
     *
     * @return array<int, array{title:string, excerpt:string, slug:string}>
     */
    function get_articles_list(int $limit = 50, int $websiteId = 1): array
    {
        $limit = max(1, min($limit, 100));

        $pdo = db();
        $stmt = $pdo->prepare(
            "SELECT titre, slug, contenu, meta_desc, image, date_publication
             FROM blog_articles
             WHERE website_id = :website_id
               AND statut = 'publié'
             ORDER BY COALESCE(date_publication, created_at) DESC
             LIMIT {$limit}"
        );
        $stmt->bindValue(':website_id', $websiteId, PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

        return array_map(
            static function (array $row): array {
                $title = trim((string) ($row['titre'] ?? ''));
                $slug = trim((string) ($row['slug'] ?? ''));
                $meta = trim((string) ($row['meta_desc'] ?? ''));
                $content = trim(strip_tags((string) ($row['contenu'] ?? '')));

                $image = trim((string) ($row['image'] ?? ''));

                return [
                    'title'   => $title,
                    'slug'    => $slug,
                    'excerpt' => $meta !== '' ? $meta : truncate($content, 160),
                    'image'   => $image !== '' ? $image : null,
                    'date'    => $row['date_publication'] ?? null,
                ];
            },
            $rows
        );
    }
}

if (!function_exists('get_article_by_slug')) {
    /**
     * Retourne un article publié par son slug.
     */
    function get_article_by_slug(string $slug, int $websiteId = 1): ?array
    {
        $pdo  = db();
        $stmt = $pdo->prepare(
            "SELECT titre, slug, h1, contenu, meta_desc, seo_title, type,
                    image, date_publication, created_at, mots
             FROM blog_articles
             WHERE website_id = :website_id
               AND slug = :slug
               AND statut = 'publié'
             LIMIT 1"
        );
        $stmt->execute([':website_id' => $websiteId, ':slug' => $slug]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ?: null;
    }
}
