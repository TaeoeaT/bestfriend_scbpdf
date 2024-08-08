<style>
	.img-container{
		height:100%;
		max-height:275px;
	}
	.img-container img{
		display: block;
		width: 100%;
		height: 100%;
		object-fit:cover;
	}
	.card-title{
		font-size: 20px
	}
	.card-title:hover{
		color: #ED1C24;
	}
	.card-text{
		font-size: 14px
	}
	.update-link{
/* 		margin-left: 20px */
	}
	.page-link {
		color: #ED1C24;
		margin: 0 3px;
	}
	.row{
		margin-left: 0px;
		margin-right: 0px;
	}
	.page-link:hover{
		color: #F4AC45;
	}
</style>

<div class="row">
<?php
include("config-db_pdf/select-data-view_pdf.php");
$perpage = 6; 
session_start();

if(isset($_POST['pagi'])) {
	$pagenum = $_POST['pagi'];
	$Previous = $pagenum-1;
	$Next = $pagenum+1;
	
	$attachments = get_posts( array(
	'post_type'      => 'sdm_downloads',
	'posts_per_page' => $perpage,
	'post_status' => 'publish',
	'order'          => 'DESC',
	'orderby'       => 'ID',
	'offset'	 => $perpage*($pagenum-1),

) );
	session_destroy();
}else{
	$pagenum = 1;
	$Previous = 1;
	$Next = $pagenum+1;	
	
$attachments = get_posts( array(
	'post_type'      => 'sdm_downloads',
	'posts_per_page' => $perpage,
	'post_status' => 'publish',
	'order'          => 'DESC',
	'orderby'       => 'ID',
	'offset'	 => $perpage*($pagenum-1),
) );
}

global $wpdb;
// $wpdb->get_results("
//                      SELECT ID FROM " . $wpdb->prefix . "posts
//                         WHERE post_type = 'sdm_downloads' AND post_status = 'publish';
//                 "); 

// $countrow = intval($wpdb->num_rows);
$countrow = count_row($wpdb);
//echo "Pagelast = ".ceil($countrow/$perpage);
	
if($Previous < 1){
	$Previous = 1;	
}elseif($Next > ceil($countrow/$perpage)){
	$Next = ceil($countrow/$perpage);
}
	
$count = count($attachments);	
	
if ( $attachments ) {
	foreach ( $attachments as $post ) {
		$id = $post->ID;
		$view = select_view($id,$wpdb);
		//echo $id;
		//echo $view;
		
		if( do_shortcode("[sdm_show_download_info id=$id download_info=title]") != "Restricted content" ){
		
	?>
	<div class="col mb-4"> 
		<div class="card h-100" style="width: 19rem;">
			<div class="img-container">
				<a href="<?php echo do_shortcode("[sdm_show_download_info id=$id download_info=download_url]"); ?>" class="update-link" data-id= "<?php echo $id ?>"  >
					<img class="img-responsive" src="
						<?php if(do_shortcode("[sdm_show_download_info id=$id download_info=thumbnail_url]") != "" ){
									echo do_shortcode("[sdm_show_download_info id=$id download_info=thumbnail_url]");
							}else{
									echo "https://media.kasperskydaily.com/wp-content/uploads/sites/92/2020/02/28163447/36C3-PDF-encryption-featured2.jpg";
		}  ?>" alt="Card image cap">
				</a>
			</div>
		  <div class="card-body"> 
			  <a href="<?php echo do_shortcode("[sdm_show_download_info id=$id download_info=download_url]"); ?>" class="update-link" data-id= "<?php echo $id ?>"  >
				<h5 class="card-title"> <?php convertThaiChars(do_shortcode("[sdm_show_download_info id=$id download_info=title]")); ?> </h5>
			  </a>
			  <div class=" d-flex flex-row ">
					<span style="font-size: 16px; align-items: center; display: inline-flex; flex-wrap: wrap; margin-bottom: 3px; padding-right: 15px;">
						<i class="far fa-calendar-alt " style="margin-right: 5px; color: #ED1C24;"></i>
						<?php echo datetimes($post->post_date); ?>
					</span>
					<span style="font-size: 16px; align-items: center; display: inline-flex; flex-wrap: wrap; margin-bottom: 3px; padding-right: 15px;">
						<i class="fa fa-file-archive-o "  style="margin-right: 5px; color: #ED1C24;"></i>
						<?php file_size(do_shortcode("[sdm_show_download_info id=$id download_info=download_url]")); ?>
					</span>	
			  </div>					
		  </div>
		  <div class="row">
			  <div class="col mb-2 " >  
				  <div class="row" style="justify-content: center; align-items: center; display: flex; font-size: 20px;">
					<a href="https://welovesteelconstruction.ssi-steel.com/?sdm_process_download=1&download_id=<?php echo $id ?>" class="card-link">
						<img width='53' height='53' src='https://welovesteelconstruction.ssi-steel.com/wp-content/uploads/2024/05/downloadiconpdf.png' alt='download--v1'/>
					  </a>
				  </div>
				  <div class="row" style="justify-content: center; align-items: center; display: flex;">
				  	<h6 style="color:#2E86AB; font-size: 18px; margin-top: 5px;"><?php echo do_shortcode("[sdm_show_download_info id=$id download_info=download_count]"); ?> Downloads</h6>
				  </div>
			  </div>
			  <div class="col mb-2"> 
				  <div class="row" style="justify-content: center; align-items: center; display: flex; font-size: 20px;">
					<a href="<?php echo do_shortcode("[sdm_show_download_info id=$id download_info=download_url]"); ?>" class="update-link" data-id= "<?php echo $id ?>" >
					<img width="50" height="50" src="https://img.icons8.com/external-dashed-line-kawalan-studio/96/ED1C24/external-eye-file-file-dashed-line-kawalan-studio.png" alt="external-eye-file-file-dashed-line-kawalan-studio"/>
					  </a>
				  </div>
				  <div class="row" style="justify-content: center; align-items: center; display: flex; font-size: 20px;">
				  		<h6 style="color:#2E86AB; font-size: 18px; margin-top: 9.5px;"><?php echo $view; ?> Views</h6>
				  </div>
			  </div>
		  </div>
		</div>
	</div>
	
	<?php 
		}
	}
	
		if( ( ($count%3) == 2) && ($count != 2) ){
		echo '
		<div class="col mb-4"> 
			<div class="card" style="width: 19rem; border: 1px solid #fff;">
			  <div class="card-body">
					<p class="card-text"></p>
			  </div>
			</div>
		</div>
		';
		
	}
	
}
	
	//echo "Next = $Next";
?>
</div>
<form method="post" action="">
	<nav aria-label="Page navigation example">
	  <ul class="pagination justify-content-center">
		  
		 <?php if (ceil($countrow/$perpage) > 0){ ?>
		  
		  <?php 
		  	if(ceil($countrow/$perpage) > 1){
				echo '
		  	<li class="page-item">
			  <button class="page-link" name="pagi" type="submit" value="1" id="btnPrevi" >
					<i class="fa fa-angle-double-left" style="font-size:20px"></i>
			  </button>
			</li>
		  	<li class="page-item">
			  <button class="page-link" name="pagi" type="submit" value=" '. $Previous . ' " id="btnPrevi" >
					<i class="fa fa-angle-left" style="font-size:20px"></i>
			  </button>
			</li>
			';
			}else{
				echo '
			<li class="page-item">
			  <button class="page-link" name="pagi" type="submit" value="1" id="btnPrevi" disabled>
					<i class="fa fa-angle-double-left" style="font-size:20px" ></i>
			  </button>
			</li>
		  	<li class="page-item">
			  <button class="page-link" name="pagi" type="submit" value=" '.$Previous.' " id="btnPrevi" disabled>
					<i class="fa fa-angle-left" style="font-size:20px"></i>
			  </button>
			</li>';
			}?>
		  
		  
		  <?php if ($pagenum-3 > 0): ?>
			<li class="page-item">
				<button class="page-link" name="pagi" type="submit" style="font-size:19px;" disabled>......</button>
			</li>
		  <?php endif; ?>
		  
		  <?php if ($pagenum-2 > 0): ?>
			<li class="page-item">
				<button class="page-link" name="pagi" type="submit" value="<?php echo $pagenum-2; ?>"  style="font-size:19px;"><?php echo $pagenum-2; ?></button>
			</li>
		  <?php endif; ?>
		  <?php if ($pagenum-1 > 0): ?>
			<li class="page-item">
				<button class="page-link" name="pagi" type="submit" value="<?php echo $pagenum-1; ?>"  style="font-size:19px;"><?php echo $pagenum-1; ?></button>
			</li>
		  <?php endif; ?>		  

			<li class="page-item">
				<button class="page-link" name="pagi" type="submit" value="<?php echo $pagenum; ?>"  style="font-size:19px; background-color: #ED1C24 ; color: #ffffff;" disabled><?php echo $pagenum; ?></button>
			</li>
		  
		  <?php if ($pagenum+1 <= ceil($countrow/$perpage)) : ?>
			<li class="page-item">
				<button class="page-link" name="pagi" type="submit" value="<?php echo $pagenum+1; ?>" id="btn-<?php echo $pagenum+1; ?>" style="font-size:19px;"><?php echo $pagenum+1; ?></button>
			</li>
		  <?php endif; ?>
		  <?php if ($pagenum+2 <= ceil($countrow/$perpage)): ?>
			<li class="page-item">
				<button class="page-link" name="pagi" type="submit" value="<?php echo $pagenum+2; ?>" id="btn-<?php echo $pagenum+2; ?>" style="font-size:19px;"><?php echo $pagenum+2; ?></button>
			</li>
		  <?php endif; ?>
		  
		  <?php if ($pagenum+3 <= ceil($countrow/$perpage)): ?>
			<li class="page-item">
				<button class="page-link" name="pagi" type="submit" style="font-size:19px;" disabled>......</button>
			</li>
		  <?php endif; ?>
		  
		  
		   <?php 
		  	if(ceil($countrow/$perpage) > 1){
				echo '
		  	<li class="page-item">
			  <button class="page-link" name="pagi" type="submit" value=" '. $Next .' ">
					<i class="fa fa-angle-right" style="font-size:20px"></i>
			  </button>
			</li>
		  	<li class="page-item">
			  <button class="page-link" name="pagi" type="submit" value=" '. ceil($countrow/$perpage) .' " id="btnPrevi">
					<i class="fa fa-angle-double-right" style="font-size:20px"></i>  
			  </button>
			</li>
			';
			}else{
				echo '
		  	<li class="page-item">
			  <button class="page-link" name="pagi" type="submit" value=" '. $Next .' " disabled>
					<i class="fa fa-angle-right" style="font-size:20px"></i>
			  </button>
			</li>
		  	<li class="page-item">
			  <button class="page-link" name="pagi" type="submit" value=" '. ceil($countrow/$perpage) .' " id="btnPrevi" disabled>
					<i class="fa fa-angle-double-right" style="font-size:20px"></i>  
			  </button>
			</li>';
			}?>
		  
		  <?php }else{
				echo "<h2 style='font-size: 20px;'>No Result</h2>";
			} ?>
		  

	  </ul>
	</nav>
</form>

<script>
$(document).ready(function() {
    // เมื่อกดปุ่มอัปเดต
    $('.update-link').click(function(e) {
        e.preventDefault();
        
        // รับค่าที่ต้องการอัปเดต
        var id = $(this).data('id');
		console.log(id);
      
        // ทำการส่งคำขอ AJAX
        $.ajax({
            type: 'POST',
            url: 'https://welovesteelconstruction.ssi-steel.com/config-db_pdf/update-view_pdf.php', // ชื่อไฟล์ PHP ที่สร้างขึ้นมาข้างบน
            data: { id: id },
            success: function(response) {
                // กระทำหลังจากได้รับการตอบกลับ
                // alert('การอัปเดตสำเร็จ: ' + response);
                // สามารถเพิ่มการปรับปรุงหน้าเว็บไซต์ได้ตามต้องการ
            },
            error: function(xhr, status, error) {
                // กระทำเมื่อเกิดข้อผิดพลาด
                // alert('เกิดข้อผิดพลาด: ' + error);
            }
        });
    });
});
</script>
