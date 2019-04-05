<template>
  <div class="Page404">
        <div class="uk-text-center uk-margin uk-padding">
            <h1 class="uk-heading-hero">404</h1><br>
            <img src="../assets/404-page.png" alt=""><br>
            <p class="uk-text-large">Sorry. The page you are trying to access appears to be missing.</p>
            <br>
            <button type="button" class="uk-button uk-button-primary uk-button-large uk-width-medium" onclick="javascript: window.history.back()">Go back</button>
        </div>
  </div>
</template>
<script>
function goBack()
{
  window.history.back();
}
// @ is an alias to /src

export default {
  name: "Page404",
};
</script>
