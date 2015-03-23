<!DOCTYPE HTML>
<html>
    <head>
        <title>Git commit log</title>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css"/>

        <style>
            #maincontent {
                margin-bottom: 50px;
            }

            footer {
                text-align: center;
                border-top: 2px solid #337AB7;
                background-color: white;

                position: fixed;
                bottom: 0;
                padding-top: 5px;
                padding-bottom: 5px;
                width: 100%;
            }
        </style>
    </head>
    <body>
        <div class="container" id="maincontent">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Author</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $content = file_get_contents('data/.commits.txt');

                        foreach (explode(PHP_EOL, $content) as $jsonString) {
                            $commitList = json_decode($jsonString);

                            foreach ($commitList as $commit) {
                                $id = htmlspecialchars($commit->id);
                                $author = htmlspecialchars($commit->author);
                                $msg = htmlspecialchars($commit->message);

                                echo "<tr><td>$id</td><td>$author</td><td>$message</td></tr>";
                            }
                        }
                    ?>
                </tbody>
            </table>

        </div>

        <footer>
            by
            <a href="http://www.v-roleplay.net">vRoleplay</a> licensed under GPL v3.0 -
            <a href="https://github.com/vRoleplay/CommitLog">GitHub</a>
        </footer>
    </body>
</html>
