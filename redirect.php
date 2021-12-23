<?php
/**
 * 重定向
 *
 * @package custom
 */
?>

<div style="display: flex;height: 100vh;justify-content: center; align-items: center;">
    <h2 style="opacity: 0.3; font-weight: 200;font-size: 2.5rem">跳转中...</h2>
</div>

<script type="text/javascript"> 
    setTimeout(()=>{window.location.href= '<?php echo $this->fields->redirectURL ;?>'},<?php echo $this->fields->redirectSecond ;?>)
</script>