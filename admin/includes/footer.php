                </main>
                <footer class="py-4 bg-dark mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">

                        </div>
                    </div>
                </footer>
            </main>
            <!-- Alertify js -->
            <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>
            <script>

                <?php 
                    if(isset($_SESSTION['message'])) 
                    { 
                        ?>
                        alertify.set('notifier','position', 'top-right');
                        alertify.success('<?= $_SESSTION['message']; ?>');
                        <?php 
                        unset($_SESSTION['message']);
                    } 
                ?>
            </script>
            </div>
        </div>
    </body>
</html>