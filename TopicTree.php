<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>主题树</title>
        <link rel="stylesheet" href="./css/jquery.treeview.css" />
        <link rel="stylesheet" href="./css/jquery.treeview.screen.css" />

        <script src="./js/jquery.js" type="text/javascript"></script>
        <script src="./js/jquery.cookie.js" type="text/javascript"></script>
        <script src="./js/jquery.treeview.js" type="text/javascript"></script>

        <script type="text/javascript" src="./js/jquery.treeview.demo.js"></script>
    </head>
    <body>
        <h4>Sample 2 - Navigation</h4>

        <ul id="navigation">
            <li><a href="?1">Item 1</a>
                <ul>
                    <li><a href="?1.0">Item 1.0</a>
                        <ul>
                            <li><a href="?1.0.0">Item 1.0.0</a></li>
                        </ul>
                    </li>
                    <li><a href="?1.1">Item 1.1</a></li>
                    <li><a href="?1.2">Item 1.2</a>
                        <ul>
                            <li><a href="?1.2.0">Item 1.2.0</a>
                                <ul>
                                    <li><a href="?1.2.0.0">Item 1.2.0.0</a></li>
                                    <li><a href="?1.2.0.1">Item 1.2.0.1</a></li>
                                    <li><a href="?1.2.0.2">Item 1.2.0.2</a></li>
                                </ul>
                            </li>
                            <li><a href="?1.2.1">Item 1.2.1</a>
                                <ul>
                                    <li><a href="?1.2.1.0">Item 1.2.1.0</a></li>
                                </ul>
                            </li>
                            <li><a href="?1.2.2">Item 1.2.2</a>
                                <ul>
                                    <li><a href="?1.2.2.0">Item 1.2.2.0</a></li>
                                    <li><a href="?1.2.2.1">Item 1.2.2.1</a></li>
                                    <li><a href="?1.2.2.2">Item 1.2.2.2</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li><a href="?2">Item 2</a>
                <ul>
                    <li><span>Item 2.0</span>
                        <ul>
                            <li><a href="?2.0.0">Item 2.0.0</a>
                                <ul>
                                    <li><a href="?2.0.0.0">Item 2.0.0.0</a></li>
                                    <li><a href="?2.0.0.1">Item 2.0.0.1</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a href="?2.1">Item 2.1</a>
                        <ul>
                            <li><a href="?2.1.0">Item 2.1.0</a>
                                <ul>
                                    <li><a href="?2.1.0.0">Item 2.1.0.0</a></li>
                                </ul>
                            </li>
                            <li><a href="?2.1.1">Item 2.1.1</a>
                                <ul>
                                    <li><a href="?2.1.1.0abc">Item 2.1.1.0</a></li>
                                    <li><a href="?2.1.1.1">Item 2.1.1.1</a></li>
                                    <li><a href="?2.1.1.2">Item 2.1.1.2</a></li>
                                </ul>
                            </li>
                            <li><a href="?2.1.2">Item 2.1.2</a>
                                <ul>
                                    <li><a href="?2.1.2.0">Item 2.1.2.0</a></li>
                                    <li><a href="?2.1.2.1">Item 2.1.2.1</a></li>
                                    <li><a href="?2.1.2.2">Item 2.1.2.2</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li><a href="?3">Item 3</a>
                <ul>
                    <li class="open"><a href="?3.0">Item 3.0</a>
                        <ul>
                            <li><a href="?3.0.0">Item 3.0.0</a></li>
                            <li><a href="?3.0.1">Item 3.0.1</a>
                                <ul>
                                    <li><a href="?3.0.1.0">Item 3.0.1.0</a></li>
                                    <li><a href="?3.0.1.1">Item 3.0.1.1</a></li>
                                </ul>
                            </li>
                            <li><a href="?3.0.2">Item 3.0.2</a>
                                <ul>
                                    <li><a href="?3.0.2.0">Item 3.0.2.0</a></li>
                                    <li><a href="?3.0.2.1">Item 3.0.2.1</a></li>
                                    <li><a href="?3.0.2.2">Item 3.0.2.2</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>

        <h4>Sample 3 - fast animations, all branches collapsed at first, red theme, cookie-based persistance</h4>

    </body>
</html>
