<?php
require_once "header.php";
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <!-- <div class="panel-heading">Dashboard</div> -->

                <div class="panel-body">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus gravida pharetra tempus. Proin placerat auctor augue posuere volutpat. Phasellus luctus dui nibh, varius luctus mi tempor nec. Praesent nec posuere turpis. Etiam tincidunt libero non pellentesque tempor. Ut imperdiet leo vestibulum turpis mattis lobortis. Pellentesque vitae iaculis nibh. Integer sit amet neque vel nisi finibus bibendum et sed augue. In hac habitasse platea dictumst. Nam lacus justo, blandit non enim nec, luctus dictum ligula. Suspendisse non sapien augue. Nullam feugiat maximus erat ac efficitur. In vel lacus nec metus fermentum placerat et id metus. Praesent sit amet placerat ligula. Donec sed pellentesque lorem. Cras eu eleifend eros, sit amet pellentesque urna. </p>
                    <p>Donec neque justo, luctus id eros ut, imperdiet mollis neque. Curabitur augue mi, interdum et dictum eu, tristique vel magna. Vivamus malesuada ipsum in diam congue porta. Etiam scelerisque, odio blandit viverra egestas, diam odio sollicitudin metus, id pretium risus tortor in neque. Etiam nec auctor libero. Duis at leo ante. Nunc eu purus id lectus tristique consectetur blandit a ex. Nullam rhoncus pulvinar auctor. Interdum et malesuada fames ac ante ipsum primis in faucibus. Suspendisse consectetur hendrerit magna, a fringilla eros elementum vitae. Morbi tincidunt sit amet libero vel convallis. Aenean ex nibh, condimentum nec ipsum sed, sollicitudin ultrices nibh. Donec non augue non tellus viverra auctor id eget turpis. Maecenas a suscipit massa. Phasellus eget lorem ac purus lobortis tincidunt in quis velit. Interdum et malesuada fames ac ante ipsum primis in faucibus. </p>
                    <p>Integer molestie, mauris ullamcorper venenatis laoreet, leo purus pretium urna, eu porta massa ipsum a nunc. Mauris vestibulum felis quis justo placerat, molestie convallis mi rutrum. Morbi auctor vestibulum laoreet. Integer sed luctus elit. Sed blandit, urna at eleifend tincidunt, risus felis posuere lorem, ac viverra nisi magna nec sem. Etiam ullamcorper lectus id tellus bibendum, ac ultricies diam lobortis. Nullam et pharetra nulla, sit amet accumsan metus. In quis turpis rhoncus, consectetur nisl ut, sodales enim. Suspendisse aliquet, leo vestibulum lobortis fermentum, ipsum felis vulputate nibh, in iaculis velit felis a risus. Nullam ornare aliquet nisl, eget convallis urna. </p>
                    <p>Cras non mauris nulla. Donec volutpat fermentum consequat. Suspendisse suscipit purus sit amet tellus pretium, eget ornare enim pellentesque. Proin velit nibh, sodales at dignissim malesuada, rutrum quis dui. Donec id pulvinar odio, eu bibendum odio. Nam tristique lacus et neque semper, sed luctus sapien rutrum. Phasellus non nibh et lorem semper placerat. Curabitur feugiat congue congue. Cras sed suscipit nisi. Nullam volutpat erat lacus, vitae scelerisque metus eleifend eu. Sed imperdiet consequat enim sit amet porta. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Duis auctor, purus nec dictum venenatis, sapien ipsum mattis tortor, sed sodales turpis nunc sed dui. </p>
                    <p>Aliquam id vulputate nunc. Donec laoreet aliquet cursus. Maecenas lorem eros, tincidunt ac consectetur sodales, aliquet quis nunc. Sed purus massa, interdum a hendrerit a, sagittis nec lorem. Nulla sapien mi, rhoncus nec consequat eu, eleifend non massa. Mauris semper ornare arcu ac tempor. Integer non lobortis magna. Integer ut felis at lacus rhoncus gravida ac vel dui. Donec sit amet purus efficitur, rhoncus lectus vitae, lacinia purus. Vivamus rhoncus cursus elit suscipit vulputate. Ut vitae nulla nec felis eleifend lobortis quis a neque. </p>
                </div>
                <span XAVIER-table="TEST" id="coba" value="AAA">AAA</span>
                <table>
                    <tbody XA-table="A">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
  console.log($(document).find("tbody").attr("XA-table"));

</script>
<?php
require_once "footer.php";
?>
