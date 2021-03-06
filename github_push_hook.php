<?php
    require_once('config.php');

    // Read raw input (to be able to parse application/json)
    $input = file_get_contents('php://input');

    // Get HTTP headers
    $headers = getallheaders();

    // Verify secret key
    if (USE_SECRET_KEY) {
        // Ensure if we got a secret key
        if (!isset($headers['X-Hub-Signature']))
            exit;

        // Check if the signature matches
        if ($headers['X-Hub-Signature'] !== 'sha1='.hash_hmac('sha1', $input, SECRET_KEY))
            exit;
    }

    // Parse JSON
    $json = json_decode($input);
    if (!$json)
        exit;

    // Iterate through pushed commits
    $result = array();
    foreach ($json->commits as $commit) {

        $info = array(
            'id' => $commit->id,
            'author' => $commit->author->username,
            'message' => $commit->message,
            'timestamp' => preg_replace('/(.*)T(.*)\+.*/', '${1} ${2}', $commit->timestamp),
            'url' => $commit->url
        );

       // Search for avatar using the author name
       if ($json->sender->login == $info['author'])
           $info['avatar_url'] = $json->sender->avatar_url;
           $info['html_url'] = $json->sender->html_url;


       // Add to result array
       array_push($result, $info);
    }

    // Append "minified" JSON string to data file
    file_put_contents('data/.commits.txt', json_encode($result)."\n", FILE_APPEND);

?>
