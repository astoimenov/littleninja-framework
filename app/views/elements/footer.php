
        </main>
        <footer class="footer navbar-fixed-bottom text-center">
            <div class="container">
                © 2015 - LittleNinja. All Rights Reserved.
            </div>
        </footer>
    </div>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="script/jquery.mousewheel.js"></script>
    <script type="text/javascript" src="script/jquery.jscrollpane.min.js"></script>
    <script>
        $(function () {
            $('body').jScrollPane();
        });
    </script>
    <script>
        $('#tags').select2({
            placeholder: 'Choose a tag',
            tags: true
        });
    </script>
</body>
</html>
