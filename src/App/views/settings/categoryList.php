<?php include $this->resolve("partials/_header.php"); ?>

<section id="mainPageContent">

<section class="py-1 col-12 col-md-10 col-lg-8 col-xl-6 col-xxl-5 text-center container">
<div class="text-start p-0 p-md-2 py-0 mb-1 border-bottom-0">
    <p class="fw-bold mb-0 fs-2"><?= $title ?>: </p>
  </div>
        
  <div class="p-0 p-md-5 py-0 fs-5">

                     <div class="container tableExpenses table-responsive">
                    
            
             <table class="table table-hover">
                       <thead>
                         <tr>
                           <th class="text-center px-1">Nr.</th>
                           <th class="px-1">Category</th>
                           <th class="text-center pe-1">Action</th>
                         </tr>
                       </thead>
            
           <!-- <tbody>
           <php foreach ($categories as $i => $row): ?>
           <tr>
                       <td class="text-center px-1 fw-bold"><= str_pad($i+1, 1, "0", STR_PAD_LEFT); ?>. </td>
                        
                       <td class="px-1"><= $row[$nameKey] ?></td>

                        
                       <td class="text-end">

                                 <div class="d-flex justify-content-evenly">
                                     
                                     <a href="<= $editBaseLink ?><= e($row[$idKey]) ?>"
                                     type="submit" class="btn icon-hover">
                                         <i class="fa-regular fa-pen-to-square fa-2xl"></i>
                                    </a>

                                  <form action="<= $deleteAction ?>" method="POST">
                                  <input type="hidden" name="id_cat" value="<= $row[$idKey]?>" />
                                     <php include $this->resolve("partials/_csrf.php"); ?>
                                     <button type="submit" class="btn icon-trash-hover">
                                             <i class="fa-regular fa-trash-can fa-2xl"></i>
                                     </button>
                                  </form>


                                 </div>
                              </td>
           </tr>
           <php endforeach; ?>
           <php foreach ($categories as $i => $row): ?>
  <td class="text-end">
    <div class="d-flex justify-content-evenly">
        
      <a href="/categories/form/<?= $type ?>/<?= $row[$idKey] ?>" class="btn icon-edit-hover">
          <i class="fa-regular fa-pen-to-square fa-2xl"></i>
      </a>

      <form method="POST" action="/categories/delete/<?= $type ?>/<?= $row[$idKey] ?>">
         <php include $this->resolve("partials/_csrf.php"); ?>
         <button type="submit" class="btn icon-trash-hover">
             <i class="fa-regular fa-trash-can fa-2xl"></i>
         </button>
      </form>
    </div>
  </td>
<php endforeach; ?>
           </tbody> -->

           <!-- <tbody>
    <php foreach ($categories as $i => $row): ?>
    <tr>
        <td class="text-center px-1 fw-bold"><= $i + 1 ?>.</td>
        <td class="px-1"><= htmlspecialchars($row[$nameKey]) ?></td>
        <td class="text-end">
            <div class="d-flex justify-content-evenly">
                
                <a href="/categories/form/<= htmlspecialchars($type) ?>/<= htmlspecialchars($row[$idKey]) ?>" class="btn icon-edit-hover">
                    <i class="fa-regular fa-pen-to-square fa-2xl"></i>
                </a>

                <a href="/categories/delete/<= htmlspecialchars($type) ?>/<= htmlspecialchars($row[$idKey]) ?>" class="btn icon-trash-hover" onclick="return confirm('Are you sure you want to delete this category?');">
                    <i class="fa-regular fa-trash-can fa-2xl"></i>
                </a>

            </div>
        </td>
    </tr>
    <php endforeach; ?>
</tbody> -->

<tbody>
    <?php foreach ($categories as $i => $row): ?>
    <tr>
        <td class="text-center px-1 fw-bold"><?= $i + 1 ?>.</td>
        <td class="px-1"><?= htmlspecialchars($row[$nameKey]) ?></td>
        <td class="text-end">
            <div class="d-flex justify-content-evenly">
                
                <a href="/categories/form/<?= htmlspecialchars($type) ?>/<?= htmlspecialchars($row[$idKey]) ?>" class="btn icon-edit-hover">
                    <i class="fa-regular fa-pen-to-square fa-2xl"></i>
                </a>

                <form method="POST" action="/categories/delete/<?= htmlspecialchars($type) ?>/<?= htmlspecialchars($row[$idKey]) ?>">
                    <?php include $this->resolve("partials/_csrf.php"); ?>
                    <button type="submit" class="btn icon-trash-hover">
                        <i class="fa-regular fa-trash-can fa-2xl"></i>
                    </button>
                </form>

            </div>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>
           
                       <tfoot>
                         <tr>
                           <th></th>
                           <th class="text-center">Total categories: </th>
                           <th class="text-center"><?= $categoryCount ?></th>      
             
                         </tr>
                       </tfoot>
                     </table>
                   <?= formError($errors, 'usedCategory') ?>
                 </div>
               </div>
             </div>
           </div>

        
         <div class="d-grid gap-2 d-md-flex justify-content-center">
           <!-- <a href="<= $addLink ?>" class="w-100 w-md-75 mb-2 btn btn-lg rounded-3 btn-primary my-2 mb-md-3" role="button">Add new category</a> -->
           <a href="/categories/form/<?= $type ?>" class="w-100 w-md-75 mb-2 btn btn-lg rounded-3 btn-primary my-2 mb-md-3" role="button">Add new category</a>
           <a href="../settings" class="w-100 w-md-75 mb-2 btn btn-lg rounded-3 btn-outline-secondary my-2 mb-md-3" role="button">   Cancel   </a>
         </div>


               </div>
   </div>
  
</section>

<?php include $this->resolve("partials/_footer.php"); ?>