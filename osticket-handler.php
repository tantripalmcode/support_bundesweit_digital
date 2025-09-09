<?php

add_action('wpforms_process_complete', 'wpf_osticket_handler', 10, 4);
function wpf_osticket_handler($fields, $entry, $form_data)
{

    LogHub::init('206808a76d06f2774f179f3954192e66078bf7c9d5b9f038c5ebf962a2995a3d');


    $form_id = $form_data['id'];
    $formfields = parse_form_fields($fields);
    $parent_id = LogHub::log('Osticket Handler Error: ' . $form_id, $formfields);
    if ($form_id == '32058' || $form_id == '32071' || $form_id == '32464' || $form_id == '36073' ) {

        // Handle attachments if available
        $attachments = get_attachments($formfields);

        // Build ticket-specific post fields
        $post_fields = build_post_fields($formfields, $form_id);

        if (count($attachments)) {
            $post_fields['attachments'] = $attachments;
        }

        // Send ticket request
        $ticket_id = send_ticket_request($post_fields);
        if ($ticket_id == "error") {
            LogHub::log('Osticket Handler Error: ' . $form_id, $post_fields, LogHub::TYPE_ERROR, parent:$parent_id);
        }else{
            LogHub::log('Osticket Handler Error: ' . $form_id, $ticket_id, LogHub::TYPE_SUCCESS, parent:$parent_id);
        }




    }
}

// Helper function to parse form fields
function parse_form_fields($fields)
{
    $formfields = [];
    foreach ($fields as $field) {
        $formfields[sanitize_title($field["name"])] = $field["value"];
    }
    return $formfields;
}

// Helper function to get attachments from form fields
function get_attachments($formfields)
{
    $attachments = [];

    if (!empty($formfields['dateien-anhaengen'])) {
        // Trenne die Dateipfade anhand von Zeilenumbrüchen
        $files = explode(PHP_EOL, $formfields['dateien-anhaengen']);

        foreach ($files as $file) {
            $path = get_path_from_url(trim($file)); // Bereinige Leerzeichen

            // Prüfe, ob der Pfad gültig ist und die Datei existiert
            if (!file_exists($path) || !is_readable($path)) {
                error_log("Datei nicht gefunden oder nicht lesbar: $path");
                continue; // Überspringe ungültige Dateien
            }

            $basename = basename($path);
            $mime = mime_content_type($path) ?: "application/octet-stream";

            // Versuche, die Datei zu lesen
            $data = file_get_contents($path);
            if ($data === false) {
                error_log("Fehler beim Lesen der Datei: $path");
                continue; // Überspringe Dateien, die nicht gelesen werden können
            }

            // Erstelle die Data-URI
            $dataUri = 'data:' . $mime . ';base64,' . base64_encode($data);

            // Füge die Datei zu den Anhängen hinzu
            $attachments[] = [$basename => $dataUri];
        }
    }

    return $attachments;
}

function get_path_from_url($url)
{
    // Überprüfen, ob es sich um eine URL handelt
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        // Verwandle URL in einen lokalen Pfad
        $parsedUrl = parse_url($url);
        $path = $_SERVER['DOCUMENT_ROOT'] . $parsedUrl['path'];
        return $path;
    }

    // Falls es keine URL ist, davon ausgehen, dass es sich um einen Pfad handelt
    return $url;
}


// Helper function to build post fields for osTicket based on form ID
function build_post_fields($formfields, $form_id)
{
    switch ($form_id) {
        case '32058':
            return [
                'email' => $formfields['e-mail'],
                'name' => $formfields['ansprechpartner'],
                'subject' => 'Extern budi Ticket / ' . $formfields['betreff'],
                'company' => $formfields['unternehmen'],
                'tel' => $formfields['telefon'],
                'weblink' => $formfields['link-zur-webseite'],
                'message' => $formfields['beschreibungstext'],
                'alert' => true,
                'autorespond' => true,
                'priority' => '2',
                'source' => 'API',
                'topicId' => '14'
            ];
        case '32071':
            return [
                'email' => $formfields['e-mail'],
                'name' => $formfields['vollstaendiger-name'],
                'subject' => 'Neues Sonstiges Budi Ticket / ' . $formfields['betreff'],
                'company' => $formfields['unternehmen'],
                'message' => $formfields['beschreibungstext'],
                'alert' => true,
                'autorespond' => true,
                'priority' => '2',
                'source' => 'API',
                'topicId' => '14'
            ];
        case '36073':
            return [
                'email' => $formfields['e-mail'],
                'name' => $formfields['ansprechpartner'],
                'subject' => 'Monday Ticket / ' . $formfields['betreff'],
                'company' => $formfields['unternehmen'],
                'message' => $formfields['beschreibungstext'],
                'alert' => true,
                'autorespond' => true,
                'priority' => '2',
                'source' => 'API',
                'topicId' => '16'
            ];
        case '32464':
            $formfields['art-des-problems'] = strtolower(str_replace(["+ ", " ", "&amp;"], "", $formfields['art-des-problems']));
            return [
                'email' => $formfields['e-mail'],
                'name' => $formfields['ansprechpartner'],
                'subject' => 'Extern branshop Ticket / ' . $formfields['unternehmen'],
                'company' => $formfields['unternehmen'],
                'gcode' => $formfields['gutscheincode'],
                'problem' => explode(PHP_EOL, $formfields['art-des-problems']),
                'message' => $formfields['beschreibungstext'],
                'alert' => true,
                'autorespond' => true,
                'priority' => '2',
                'source' => 'API',
                'topicId' => '15'
            ];
    }
    return [];
}

// Helper function to send ticket request to osTicket
function send_ticket_request($post_fields)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://tickets.budigital.de/api/tickets.json");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'X-API-Key: 4CA5E2F341D45CB45A8D0ABD91DE06CF'
    ]);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_fields));
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

    $ticket_id = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    error_log("Ticket ID: $code");
    if($code != 201){
        return "error";
    }

    return $ticket_id;
}
