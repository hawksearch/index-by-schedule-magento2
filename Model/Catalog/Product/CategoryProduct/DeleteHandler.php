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
namespace HawkSearch\IndexBySchedule\Model\Catalog\Product\CategoryProduct;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\ResourceModel\CategoryProduct;
use Magento\Framework\EntityManager\Operation\ExtensionInterface;

/**
 * Delete Handler for Product Relations.
 */
class DeleteHandler implements ExtensionInterface
{
    /**
     * @var CategoryProduct
     */
    private $categoryProduct;

    /**
     * @param CategoryProduct $categoryProduct
     */
    public function __construct(
        CategoryProduct $categoryProduct
    )
    {
        $this->categoryProduct = $categoryProduct;
    }

    /**
     * Delete Category links for the provided product.
     *
     * @param ProductInterface $entity
     * @param array $arguments
     * @return ProductInterface|object
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute($entity, $arguments = [])
    {
        $connection = $this->categoryProduct->getConnection();
        $connection->delete($this->categoryProduct->getMainTable(),['product_id = ?' => $entity->getId()]);

        return $entity;
    }
}
