  <?php include $this->resolve("partials/_header.php"); ?>

  <!-- mainPageContent -->
  <section id="mainPageContent">

    <section class="py-3 text-center container">
      
      <?php include $this->resolve("partials/_balanceHeader.php"); ?>	
      
      <?php include $this->resolve("partials/_menuSettings.php"); ?> 
	  
      <?php include $this->resolve("partials/_toggleButtons.php"); ?>

    </section>

    <section>
      <?php include $this->resolve("partials/_{$balanceMode}Table.php"); ?>
    </section>

    <section class="py-3 text-center container">

      <?php include $this->resolve("partials/_balanceSummary.php"); ?>
      <?php include $this->resolve("partials/_balanceChart.php"); ?>

    </section>
  </section>
  
<!-- Footer -->
<?php include $this->resolve("partials/_footer.php"); ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

  <script>
   const chartLabels = <?= json_encode($chartLabels) ?>;
    const chartData = <?= json_encode($chartData) ?>;
  </script>
 
  <script src="/js/chart.js"></script>

</body>

</html>