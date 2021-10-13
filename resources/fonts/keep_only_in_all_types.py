import os

repertoire = "C:/Users/marco/Downloads/iconsax-svg/Svg/All/"
outline = os.listdir(repertoire + 'outline')
bold = os.listdir(repertoire + 'bold')

print("outline")

for i in range(len(outline)):
    fichier = repertoire + "outline/" + outline[i]

    if not(outline[i] in bold):
        os.remove(fichier)
        print(outline[i])

print("bold")

for i in range(len(bold)):
    fichier = repertoire + "bold/" + bold[i]

    if not(bold[i] in outline):
        os.remove(fichier)
        print(bold[i])
        break

    with open(fichier, "r", encoding="utf-8", errors='ignore') as f:
        lines = f.readlines()

    with open(fichier, "w", encoding="utf-8", errors='ignore') as f:
        for line in lines:
            if not("opacity" in line):
                f.write(line)
            else:
                print("opacity detected in " + bold[i])