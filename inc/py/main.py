import sys
from extraction import extract_text_from_pdf

if __name__ == "__main__":
    if len(sys.argv) < 2:
        print("Erreur : chemin du fichier non spécifié.")
        sys.exit(1)

    file_path = sys.argv[1]

    try:
        cv_text = extract_text_from_pdf(file_path)
        print(cv_text)
    except Exception as e:
        print(f"Erreur : {str(e)}")
        sys.exit(1)
