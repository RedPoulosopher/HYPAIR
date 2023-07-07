## A suivre

- [ ] Aligner le titre et l'auteur du post
- Ajouter les icônes
    - [ ] Calendrier
    - [ ] Flèche pour description
- [ ] Animer la rotation de la flèche quand on clique dessus et le déroulement de la description
- [ ] S'assurer que la page est bien responsive
- [x] Implémenter les polices
- [ ] Créer les variables pour les données à récupérer depuis le back-end (voir plus bas)
- [ ] Créer des tags de couleur différentes
- [ ] Ajuster la taille des éléments : il me semble que c'est un peu grand actuellement.

## Problèmes

- Quand on clique sur la flèche pour dérouler le post, seule la description du 1er post apparaît. J'en conclus que les components ne sont pas indépendants les uns des autres, ce qui est un peu problématique vu qu'ils sont censés chacun marcher indépendemment les uns des autres...
Et en fait c'est logique puisque les components apparaissent directement en tant que code HTML coté client.

>Je pense avoir la solution pour gérer ce problème : associer à chaque post un numéro unique et ajouter ce numéro aux ID des élements du components, pour qu'ils aient tous un nom unique.

## Données à récupérer du back-end et à passer en argument

- Thumbnail du post
- Titre
- Auteur
- Tags
- Date de l'event
- Description
