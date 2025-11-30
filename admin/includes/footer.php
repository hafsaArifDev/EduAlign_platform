<!DOCTYPE html>
<html>
<head>
    <style>

        /* FOOTER DESIGN */
        .main-footer {
            background: linear-gradient(135deg, #1abc9c, #3498db);
            color: white;
            text-align: center;
            padding: 15px 0;
            font-size: 15px;
            font-weight: 600;
            margin-top: 40px;
            box-shadow: 0 -3px 12px rgba(0,0,0,0.15);
            height: 10px;
            align-content: center;
        }

        p {
            margin-top: -4px;
        }
        /* Footer always stays at bottom */
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        /* Push footer to bottom when content is short */
        .content-wrapper {
            flex: 1;
        }

    </style>
</head>

<body>


<!-- FOOTER -->
<footer class="main-footer">
    <p>© <?= date("Y") ?> EduAlign Platform</p>
</footer>

</body>
</html>