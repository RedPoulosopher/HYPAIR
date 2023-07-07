## A suivre

- Aligner le titre et l'auteur du post
- Mettre les images (Icône du post, du calendrier et flèche pour dérouler la description)
- Animer la rotation de la flèche quand on clique dessus et le déroulement de la description
- S'assurer que la page est bien responsive
- Implémenter les polices

## Problèmes

- Quand on clique sur la flèche pour dérouler le post, seule la description du 1er post apparaît. J'en conclus que les components ne sont pas indépendants les uns des autres, ce qui est un peu problématique vu qu'ils sont censés chacun marcher indépendemment les uns des autres...
Je pense avoir la solution pour gérer ce problème : associer à chaque post un numéro unique et ajouter ce numéro aux ID des élements du components, pour qu'ils aient tous un nom unique.

## Données a recuperer du back-end et à passer en argument

- Thumbnail du post
- Titre
- Auteur
- Tags
- Date de l'event
- Description
