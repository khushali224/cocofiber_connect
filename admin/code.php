<?php
include('../config/db.php');
session_start();



// Delete Order
if (isset($_POST['order_delete'])) {
    $order_id = mysqli_real_escape_string($con, $_POST['order_delete']);
    $query = "DELETE FROM orders WHERE id = '$order_id'";
    mysqli_query($con, $query);
    header("Location: manage-order.php");
    exit();
}


if(isset($_POST['reviews_delete']))
{
    $id = $_POST['reviews_delete'];

    $query = "DELETE FROM `contact_review` WHERE id='$id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Reviews Deleted Successfully";
        header('Location: manage-reviews.php');
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Something Went Wrong";
        header('Location: manage-reviews.php');
        exit(0);
    }
}

if(isset($_POST['products_delete']))
{
    $id = $_POST['products_delete'];

    $query = "DELETE FROM `products` WHERE id='$id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Product Deleted Successfully";
        header('Location: product-view.php');
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Something Went Wrong";
        header('Location: product-view.php');
        exit(0);
    }
}



if(isset($_POST['products_update']))
{
    $id = $_POST['id'];
    $pname = $_POST['pname'];
    $description = $_POST['description'];	
    $price = $_POST['price'];
    $status = isset($_POST['status']) ? 'In_stock':'Out_stock';

    $image = $_FILES["image"]["name"];
    $old_image = $_POST['old_image'];

    if($image != "")
    {
        //$update_filename = $pimage;
        $pimage_ext = pathinfo($image, PATHINFO_EXTENSION);
        $update_filename = time().'.'.$pimage_ext;
    }
    else
    {
        $update_filename = $old_image;
    }


    $query = "UPDATE products SET pname='$pname',description='$description',price='$price',image='$image',status='$status' WHERE id='$id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        if($_FILES['image']['name'] != "")
        {
            move_uploaded_file($_FILES['image']['tmp_name'], $path.'/'.$update_filename);
            if(file_exists("../uploads/".$old_image))
            {
                unlink("../uploads/".$old_image);
            }
        }
        $_SESSION['message'] = "Product Update Successfully";
        header('Location: product-view.php?id='.$id);
        exit(0);

        
    }
    else
    {
        $_SESSION['message'] = "Something Went Wrong";
        header('Location: product-edit.php?id='.$id);
        exit(0);
    }
}


if(isset($_POST['products_add']))
{   
    $id = $_POST['id'];
    $pname = $_POST['pname'];
    $description = $_POST['description'];	
    $price = $_POST['price'];
    $image = $_FILES["image"]["name"];

    $path = "../uploads";

    $pimage_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time().'.'.$pimage_ext;
    $status = isset($_POST['status']) ? 'In_stock':'Out_stock';
    

    //move_uploaded_file($_FILES["packageimage"]["tmp_name"], "packageimages/".$pimage);

    $query = "INSERT INTO products(id,pname,description,price,image,status) VALUES('$id','$pname','$description','$price','$image','$status')";


    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        move_uploaded_file($_FILES["image"]["tmp_name"], $path.'/'.$filename);
        
        $_SESSION['message'] = "Product Added Successfully";
        header('Location: product-add.php');
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Something Went Wrong";
        header('Location: product-add.php');
        exit(0);
    }
}

if(isset($_POST['categories_delete']))
{
    $id = $_POST['categories_delete'];

    $query = "DELETE FROM `categories` WHERE id='$id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Categories Deleted Successfully";
        header('Location: categories-view.php');
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Something Went Wrong";
        header('Location: categories-view.php');
        exit(0);
    }
}



if(isset($_POST['categories_update']))
{
    $id = $_POST['id'];
    $category_name = $_POST['category_name'];


    $query = "UPDATE categories SET category_name='$category_name 'WHERE id='$id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
       
        $_SESSION['message'] = "Category Update Successfully";
        header('Location: view-categories.php?id='.$id);
        exit(0);

        
    }
    else
    {
        $_SESSION['message'] = "Something Went Wrong";
        header('Location: edit-categories.php?id='.$id);
        exit(0);
    }
}


if(isset($_POST['categories_add']))
{   
    $id = $_POST['id'];
    $category_name = $_POST['category_name'];
   
    

    //move_uploaded_file($_FILES["packageimage"]["tmp_name"], "packageimages/".$pimage);

    $query = "INSERT INTO categories(id,category_name) VALUES('$id','$category_name')";


    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
      
        
        $_SESSION['message'] = "categories Added Successfully";
        header('Location: view-categories.php');
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Something Went Wrong";
        header('Location: add-categories.php');
        exit(0);
    }
}

if(isset($_POST['user_delete']))
{
    $user_id = $_POST['user_delete'];

    $query = "DELETE FROM `registration` WHERE id='$user_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "User/Admin Deleted Successfully";
        header('Location: view-register.php');
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Something Want Wrong";
        header('Location: view-register.php');
        exit(0);
    }
}


if(isset($_POST['admin_delete']))
{
    $user_id = $_POST['admin_delete'];

    $query = "DELETE FROM `admins` WHERE id='$user_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "User/Admin Deleted Successfully";
        header('Location: view_admin.php');
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Something Want Wrong";
        header('Location: view_admin.php');
        exit(0);
    }
}

if (isset($_POST['add_admin'])) {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $email    = isset($_POST['email']) ? $_POST['email'] : '';
    $phone    = isset($_POST['phone']) ? $_POST['phone'] : '';
    $role_as  = isset($_POST['role_as']) ? $_POST['role_as'] : 'admin';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // ✅ Hash password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $query = "INSERT INTO admins (username, email, phone, role_as, password)
              VALUES ('$username', '$email', '$phone', '$role_as', '$hashedPassword')";

    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $_SESSION['message'] = "Admin/User Added Successfully";
        header('Location: view_admin.php');
        exit(0);
    } else {
        $_SESSION['message'] = "Something Went Wrong";
        header('Location: view_admin.php');
        exit(0);
    }
}

if (isset($_POST['update_admin'])) {
    $user_id  = mysqli_real_escape_string($con, $_POST['id']);
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email    = mysqli_real_escape_string($con, $_POST['email']);
    $phone    = mysqli_real_escape_string($con, $_POST['phone']);
    $role_as  = mysqli_real_escape_string($con, $_POST['role_as']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // ✅ Hash new password only if provided
    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $update_query = "UPDATE admins SET 
            username = '$username',
            email = '$email',
            phone = '$phone',
            role_as = '$role_as',
            password = '$hashedPassword'
            WHERE id = '$user_id'";
    } else {
        // If password field is empty, don't update password
        $update_query = "UPDATE admins SET 
            username = '$username',
            email = '$email',
            phone = '$phone',
            role_as = '$role_as'
            WHERE id = '$user_id'";
    }

    $query_run = mysqli_query($con, $update_query);

    if ($query_run) {
        $_SESSION['message'] = "Updated Successfully";
        header('Location: view_admin.php');
        exit(0);
    } else {
        echo "Update failed: " . mysqli_error($con);
    }
}


?>