@include('admin.base.start')

@include('admin.base.navbar')

<!-- start wrapper -->
<div class="h-screen flex flex-row flex-wrap">
  
  @include('admin.base.sidebar')

  <!-- start content -->
  <div class="bg-gray-100 flex-1 p-6 md:mt-16"> 

    <!-- congrats & summary -->
    <div class="grid grid-cols-3 lg:grid-cols-1 gap-5">
      @include('admin.index.congrats')
      @include('admin.index.summary')      
    </div>
    <!-- end congrats & summary -->

    <!-- status -->
    @include('admin.index.status')
    <!-- end status -->

    <!-- best seller & traffic -->
    <div class="grid grid-cols-2 lg:grid-cols-1 gap-5 mt-5">
      @include('admin.index.bestSeller')
      @include('admin.index.recent_order')      
    </div>
    <!-- end best seller & traffic -->
        

  </div>
  <!-- end content -->

</div>
<!-- end wrapper -->

@include('admin.base.end')
