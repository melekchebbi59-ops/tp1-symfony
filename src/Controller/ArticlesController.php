#[Route('/articles', name: 'app_articles')]
public function index(): Response
{
$articles = [
['titre' => 'Introduction à Symfony', 'auteur' => 'Alice', 'publie' => tr
ue],
['titre' => 'Les bases de Twig', 'auteur' => 'Bob', 'publie' => t
rue],
['titre' => 'Doctrine ORM en pratique', 'auteur' => 'Claire', 'publie' => f
alse],
['titre' => 'Sécurité avec Symfony', 'auteur' => 'David', 'publie' => t
rue],
['titre' => 'API Platform (brouillon)', 'auteur' => 'Eve', 'publie' => f
alse],
];

return $this->render('articles/index.html.twig', [
'articles' => $articles,
]);
}
