<?php
/**
 * Created by PhpStorm.
 * User: JOBZREFER
 * Date: 11/24/2016
 * Time: 11:06 AM
 */

namespace AdminBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class PurchaseAdmin extends AbstractAdmin
{
    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'id'
    );
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Chi tiết', array(
                'class' => 'col-md-4',
                'box_class' => 'box'
            ))
//            ->add('purchaseNo', 'text', ['label' => 'Mã đơn hàng'])
//            ->add('deliveryDate', 'sonata_type_date_picker', array(
//                'label' => 'Ngày Giao',
//                'format' => 'yyyy/MM/dd',
//                'required' => FALSE
//            ))
//            ->add('createdAt', 'sonata_type_date_picker', array(
//                'label' => 'Tạo Ngày',
//                'format' => 'yyyy/MM/dd',
//                'required' => FALSE
//            ))
//            ->add('deliveryHour', 'time', array(
//                'label' => 'Giờ Giao',
//                'required' => FALSE
//            ))
            ->add('customerName', 'text', ['label' => 'Tên khách hàng'])
            ->add('customerPhone', 'text', ['label' => 'SĐT khách hàng'])
//            ->add('customerEmail', 'email', ['label' => 'Email khách hàng'])
            ->add('customerAddress', 'text', ['label' => 'Địa chỉ khách hàng'])
            ->add('customerDescription', 'ckeditor', array(
                'config' => array(
                    'toolbar' => array(
                        array(
                            'name' => 'basicstyles',
                            'items' => array(
                                'Bold', 'Italic', 'Underline',
                                '-', 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord',
                                '-', 'Undo', 'Redo',
                                '-', 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent',
                                '-', 'Blockquote',
                                '-', 'Image', 'Link', 'Unlink', 'Table'
                            )
                        )
                    ),
                    'uiColor' => '#ffffff'
                ),
                'label' => 'Ghi chú thêm'
            ))
            ->end()
            ->with('Chi tiết đơn hàng', array('class' => 'col-sm-8'))
            ->add('purchasedItems', 'sonata_type_collection',
                array('btn_add' => false,
                    'by_reference' => false,
                    'label' => 'Chi tiết hoá đơn',
                    'type_options' => array('delete' => false, 'btn_add' => false))
                ,array(
                    'edit' => 'inline',
                    'inline' => 'class',
                    'required' => FALSE,
                )
            )
            ->add('totalPrice', 'number', ['label' => 'Số tiền đơn hàng', 'required' => FALSE, 'attr' => array()])
            ->add('shipPrice', 'number', ['label' => 'Tiền Ship', 'required' => FALSE, 'attr' => array()])
            ->add('totalAll', 'number', ['label' => 'Tổng số tiền', 'required' => FALSE, 'attr' => array()])
            ->end()
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('customerName')->add('customerPhone')->add('customerEmail');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id')->addIdentifier('customerName')->addIdentifier('customerPhone')->addIdentifier('customerEmail')->addIdentifier('createdAt');
    }

    public function prePersist($object)
    {
        $this->preUpdate($object);
    }

    public function preUpdate($object)
    {

    }

}