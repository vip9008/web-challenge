<?php

use yii\helpers\Url;
use app\models\Tree;
use vip9008\materialgrid\widgets\ActiveForm;

$this->title = 'Web Challenge';
?>

<div class="row">
<?php if (!file_exists($filepath)) { ?>
    <div class="col medium-12">
        <h3 class="orange">JSON file does not exist!</h3>
        <p><?= $filepath ?></p>
    </div>
<?php } else { ?>
    <div class="col medium-12">
        <div id="tree">
            <div class="node node-id-root">
                <i class="btn color white" data-id="root"></i>
            </div>
        </div>

        <div class="space"></div>

        <?php $form = ActiveForm::begin(['action' => ['site/export'], 'id' => 'export-form']) ?>
            <button type="submit" class="btn raised color orange">Export tree</button>
            <textarea name="Tree[json]" id="export-json" class="hidden"></textarea>
        <?php ActiveForm::end() ?>
    </div>
    <script type="text/javascript">
        var tree = <?= Tree::getTree($filepath) ?>;

        function insertNode(node) {
            var element = $('<div>', {'class': 'node'});
            element.html('<i class="btn color white">Title: '+node.title+', ID: '+node.id+'</i>');
            element.children('.btn').attr('data-id', node.id).attr('data-title', node.title);
            element.addClass('node-id-'+node.id);

            if (node.next_node_id.length) {
                element.addClass('node-child-'+node.next_node_id);
            }

            if (node.previous_sibling_id.length) {
                element.insertAfter('#tree .node.node-id-'+node.previous_sibling_id);
            } else {
                if ($('#tree .node.node-child-'+node.id).length) {
                    $('#tree .node.node-child-'+node.id).append(element);
                } else {
                    $('#tree .node.node-id-root').append(element);
                }
            }
        }

        function constructJson(element) {
            var json = [];
            element.each(function (i) {
                var nodes = [];
                if ($(this).children('.node').length) {
                    nodes = constructJson($(this).children('.node'));
                }
                json.push({
                    id: $(this).children('.btn').attr('data-id'),
                    title: $(this).children('.btn').attr('data-title'),
                    nodes: nodes
                });
            });

            return json;
        }

        $('#export-form').on('submit', function (e) {
            var json = constructJson($('#tree > .node.node-id-root'));
            $('#export-json').val(JSON.stringify(json));
        });

        $('#tree > .node.node-id-root > .btn').html('Title: '+tree.tree_title).attr('data-title', tree.tree_title);

        $.each(tree.tree_nodes, function(index, node) {
            insertNode(node);
        });
    </script>
<?php } ?>
</div>

<div class="space"></div>
<a class="btn raised color orange-900" href="<?= Url::home() ?>">Go back</a>