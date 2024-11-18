<?php 
    function extractTextFromPdf($pdfFile) {
        $uploadDir = 'inc/uploads/';
        $uploadFile = $uploadDir . basename($pdfFile['name']);
        $valeur = [];
        $valeur['chemin'] = $uploadFile;

        // Assurez-vous que le répertoire de destination existe
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
    
        // Déplacer le fichier téléchargé vers le dossier de destination
        if (move_uploaded_file($pdfFile['tmp_name'], $uploadFile)) {
            echo "Le fichier a été téléchargé avec succès.<br>";
        } else {
            return "Erreur lors du téléchargement du fichier.";
        }
    
        // Exécuter le script Python
        $output = null;
        $return_var = null;
        exec("python inc/py/main.py " . escapeshellarg($uploadFile) . " 2>&1", $output, $return_var);
    
        // Convertir la sortie en texte UTF-8
        $val = implode("\n", $output);
        $utf8_string = mb_convert_encoding($val, 'UTF-8', 'ISO-8859-1');
    
        if ($return_var === 0) {
            $valeur['contenu'] = $utf8_string;
            return $valeur; // Retourne le texte extrait
        } else {
            // Retourner l'erreur si le script Python échoue
            return "Erreur lors de l'exécution du script Python : " . htmlspecialchars($val);
        }
    }


    function extractAndDecodeJson($responseContent) {
        // Supprimer les balises de code s'il y en a
        $cleanContent = preg_replace('/^```json\s*/', '', $responseContent); // Supprime la balise d'ouverture
        $cleanContent = preg_replace('/```$/', '', $cleanContent); // Supprime la balise de fermeture
    
        // Décoder le JSON en tableau PHP
        $jsonArray = json_decode($cleanContent, true);
    
        // Vérifier si le JSON a été décodé correctement
        if ($jsonArray !== null) {
            return $jsonArray;
        } else {
            return "Erreur lors du décodage du JSON.";
        }
    }


    function analyzeCV($cvtext, $exigenceText) {
        // Préparer le prompt
        $debutpharse = "Voici un CV";
        $question = "analyse le cv,
    
    note la compétence, experience et l'education du cv par rapport à l'experience fais le sur 5
    puis sectionne le cv par la compétence, experience et l'education
    et donne le potentiel que peut donner le cv pour le poste, soit très sevère sur la note,
    identifie le texte de chaque section et mais le dans le json
    
    return juste un json de l'analyse, dans le format suivant";
        $exemple = '{
          "education": ["content" : ses éducation en text, "note": 3],
          "experience": ["content" : ses experience en text, "note": 3],
          "competence": ["content" : ses compétence en text, "note": 3]
          "remarque: tes remarque"
        }';
    
        // Créer le prompt final
        $fullPrompt = $debutpharse . "\n\n" . $cvtext . "\n\n" . $exigenceText . "\n\n" . $question . "\n\n" . $exemple;
    
        // Initialisation de cURL pour l'API OpenAI
        $curl = curl_init();
    
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.openai.com/v1/chat/completions",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'model' => 'gpt-4o-mini', // Utilisez 'gpt-4' si disponible
                'messages' => [
                    ['role' => 'system', 'content' => 'Tu es un assistant qui analyse les CV.'],
                    ['role' => 'user', 'content' => $fullPrompt]
                ],
                'max_tokens' => 1500
            ]),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Authorization: Bearer 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"
            ],
        ]);
    
        $response = curl_exec($curl);
        $err = curl_error($curl);
    
        curl_close($curl);
    
        if ($err) {
            return "Erreur cURL #: " . $err;
        } else {
            // Traitement de la réponse
            $data = json_decode($response, true);
            if (isset($data['choices'][0]['message']['content'])) {
                $content = $data['choices'][0]['message']['content'];
                // Décoder le JSON contenu dans la réponse
                return extractAndDecodeJson($content) ?: "Erreur lors du décodage du JSON.";
            } else {
                return "Analyse du CV échouée ou réponse inattendue : " . $response;
            }
        }
    }
   
?>