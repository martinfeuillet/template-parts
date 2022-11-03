<div class="search-container">
  <div class="container">
    <header>
      <button class="closeButton"></button>  
    </header>

    <form class="col-xs-12">
      <input type="text" placeholder="" id="searchInput">
      <input type="hidden" name="from_page_id" value="<?php echo absint( get_the_ID() ); ?>">
      <button class="button-search"></button>
    </form>

    <div class="col-xs-12 results">
      <div class="row">
        <div class="col-xs-4 result-categ">
          <h4><?php _e( 'Formations', 'crea' ) ?></h4>

          <ul id="results_formations"></ul>

          <div class="pagination">
            <a href="#" class="prev"></a>
            <a href="#" class="next"></a>
          </div>
        </div>

        <div class="col-xs-4 result-categ">
          <h4><?php _e( 'Blog', 'crea' ) ?></h4>

          <ul id="results_blog"></ul>

          <div class="pagination">
            <a href="#" class="prev"></a>
            <a href="#" class="next"></a>
          </div>
        </div>
        
        <div class="col-xs-4 result-categ">
          <h4><?php _e( 'Pages', 'crea' ) ?></h4>

          <ul id="results_pages"></ul>

          <div class="pagination">
            <a href="#" class="prev"></a>
            <a href="#" class="next"></a>
          </div>
        </div>
        
      </div>
    </div>
  </div>
  
  <div class="loader">
  	<div class="loader-element"></div>
  	<p><?php esc_html_e( 'Veuillez patienter...', 'crea' ) ?></p>
  </div>
  
</div>
