<?php
// Configuration du serveur
$host = 'localhost';
$port = 8000;

// Création du serveur
$server = stream_socket_server("tcp://$host:$port", $errno, $errstr);

if (!$server) {
    die("Erreur lors de la création du serveur : $errstr ($errno)");
}

echo "Serveur démarré sur http://$host:$port\n";

// Fonction pour déterminer le type MIME
function getMimeType($file) {
    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    $mimeTypes = [
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'html' => 'text/html',
        'webp' => 'image/webp',
        'css' => 'text/css',
        'js' => 'application/javascript'
    ];
    return $mimeTypes[$extension] ?? 'application/octet-stream';
}

// Boucle principale du serveur
while ($conn = stream_socket_accept($server)) {
    // Lecture de la requête
    $request = fread($conn, 1024);
    
    // Extraction du chemin demandé
    if (preg_match('/GET (.*?) HTTP/', $request, $matches)) {
        $path = $matches[1];
        
        // Si le chemin est /, servir index.html
        if ($path === '/') {
            $path = '/index_temp.html';
        }
        
        // Chemin complet du fichier
        $filePath = 'public' . $path;
        
        // Vérifier si le fichier existe
        if (file_exists($filePath)) {
            // En-têtes de réponse
            $headers = "HTTP/1.1 200 OK\r\n";
            $headers .= "Content-Type: " . getMimeType($filePath) . "; charset=UTF-8\r\n";
            $headers .= "Connection: close\r\n\r\n";
            
            // Lecture et envoi du contenu
            $content = file_get_contents($filePath);
            fwrite($conn, $headers . $content);
        } else {
            // Fichier non trouvé
            $headers = "HTTP/1.1 404 Not Found\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            $headers .= "Connection: close\r\n\r\n";
            fwrite($conn, $headers . "<h1>404 - Fichier non trouvé</h1>");
        }
    }
    
    fclose($conn);
}

// Fermeture du serveur
fclose($server);
?> 