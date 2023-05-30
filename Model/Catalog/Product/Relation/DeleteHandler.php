<?php
/**
 * Copyright (c) 2023 Hawksearch (www.hawksearch.com) - All Rights Reserved
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 */
namespace HawkSearch\IndexBySchedule\Model\Catalog\Product\Relation;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\ResourceModel\Product\Relation;
use Magento\Framework\EntityManager\Operation\ExtensionInterface;

/**
 * Delete Handler for Product Relations.
 */
class DeleteHandler implements ExtensionInterface
{
    /**
     * @var Relation
     */
    private $catalogProductRelation;

    /**
     * @param Relation $catalogProductRelation
     */
    public function __construct(
        Relation $catalogProductRelation
    )
    {
        $this->catalogProductRelation = $catalogProductRelation;
    }

    /**
     * Delete Product Relations for the provided child product.
     *
     * @param ProductInterface $entity
     * @param array $arguments
     * @return ProductInterface|object
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute($entity, $arguments = [])
    {
        $connection = $this->catalogProductRelation->getConnection();
        $select = $connection->select()
            ->from($this->catalogProductRelation->getMainTable(), ['parent_id'])
            ->where('child_id = ?', $entity->getId());
        $parentIdsOfChildIds = array_column($connection->fetchAll($select), 'parent_id');
        foreach ($parentIdsOfChildIds as $parentId) {
            $this->catalogProductRelation->removeRelations($parentId, [$entity->getId()]);
        }

        return $entity;
    }
}
