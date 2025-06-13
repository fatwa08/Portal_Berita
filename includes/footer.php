</main>
</div> 
<footer class="app-footer">
    <p>&copy; <?php echo date("Y"); ?> Fatwa Ahmad Rangkuti</p>
</footer>

</body>
</html>
<?php
// Menutup koneksi untuk melepaskan resource
if (isset($stmt)) {
    $stmt->close();
}
if (isset($koneksi)) {
    $koneksi->close();
}
?>