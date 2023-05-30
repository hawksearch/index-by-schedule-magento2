# Index By Schedule Fixes

After installing this extension the folowing Mview subscriptions work correctly for "By Schedule" indexer mode 
when product entity is deleted:
```xml
<view id="hawksearch_products" class="HawkSearch\EsIndexing\Model\Indexer\Product" group="indexer">
    <subscriptions>
        <table name="catalog_category_product" entity_column="product_id" />
        <table name="catalog_product_relation" entity_column="parent_id"/>
    </subscriptions>
</view>
```
Bug reference link: [catalog_product_relation is unsuitable for mview](https://github.com/magento/magento2/issues/31061)
