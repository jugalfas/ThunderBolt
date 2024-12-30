import React from "react";
import PropTypes from "prop-types";
import { Link, usePage } from "@inertiajs/react";
import {
    Navbar as MTNavbar,
    Typography,
    Button,
    IconButton,
    MobileNav,
} from "@material-tailwind/react";
import { Bars3Icon, XMarkIcon } from "@heroicons/react/24/outline";

export function Navbar({ brandName = "ThunderBolt", action }) {
    const [openNav, setOpenNav] = React.useState(false);
    const user = usePage().props.auth.user;

    React.useEffect(() => {
        window.addEventListener(
            "resize",
            () => window.innerWidth >= 960 && setOpenNav(false)
        );
    }, []);

    const navList = (
        <ul className="mb-4 mt-2 flex flex-col gap-2 text-inherit lg:mb-0 lg:mt-0 lg:flex-row lg:items-center lg:gap-6">
            <Typography
                key="home"
                as="li"
                variant="small"
                color="inherit"
                className="capitalize"
            >
                <Link
                    href="/"
                    className="flex items-center gap-1 p-1 font-bold"
                >
                    Home
                </Link>
            </Typography>
        </ul>
    );

    // Ensure 'action' is a valid React element or provide a fallback
    const actionElement = action
        ? React.cloneElement(action, {
              className: "hidden lg:inline-block",
          })
        : null;

    return (
        <MTNavbar color="transparent" className="p-3">
            <div className="container mx-auto flex items-center justify-between text-white">
                <Link to="/">
                    <Typography className="mr-4 ml-2 cursor-pointer py-1.5 font-bold">
                        {brandName}
                    </Typography>
                </Link>
                <div className="hidden lg:block">{navList}</div>
                <IconButton
                    variant="text"
                    size="sm"
                    color="white"
                    className="text-inherit hover:bg-transparent focus:bg-transparent active:bg-transparent "
                    onClick={() => setOpenNav(!openNav)}
                >
                    {openNav ? (
                        <XMarkIcon strokeWidth={2} className="h-6 w-6" />
                    ) : (
                        <Bars3Icon strokeWidth={2} className="h-6 w-6" />
                    )}
                </IconButton>
            </div>
            <MobileNav
                className="block w-1/4 basis-full overflow-hidden rounded-xl bg-white px-4 pt-2 pb-4 text-blue-gray-900 absolute right-0"
                open={openNav}
            >
                <div className="container mx-auto">
                    {user ? (
                        <>
                            <Typography
                                key="user_name"
                                as="li"
                                variant="small"
                                color="inherit"
                                className="capitalize"
                            >
                                <span className="flex items-center gap-1 p-1 font-bold">
                                    {user.first_name} {user.last_name}
                                </span>
                            </Typography>
                            <Typography
                                key="profile"
                                as="li"
                                variant="small"
                                color="inherit"
                                className="capitalize"
                            >
                                <Link
                                    href="/profile"
                                    className="flex items-center gap-1 p-1 font-bold"
                                >
                                    Profile
                                </Link>
                            </Typography>
                            <Typography
                                key="logout"
                                as="li"
                                variant="small"
                                color="inherit"
                                className="capitalize"
                            >
                                <Link
                                    href={route("logout")} // Use Laravel's route helper if available
                                    method="post" // Specify the POST method
                                    as="button" // Render as a button to prevent browser navigation
                                    className="flex items-center gap-1 p-1 font-bold text-red-600 hover:text-red-800"
                                >
                                    Logout
                                </Link>
                            </Typography>
                        </>
                    ) : (
                        <>
                            <Typography
                                key="login"
                                as="li"
                                variant="small"
                                color="inherit"
                                className="capitalize"
                            >
                                <Link
                                    href="/login"
                                    className="flex items-center gap-1 p-1 font-bold"
                                >
                                    Login
                                </Link>
                            </Typography>
                            <Typography
                                key="register"
                                as="li"
                                variant="small"
                                color="inherit"
                                className="capitalize"
                            >
                                <Link
                                    href="/register"
                                    className="flex items-center gap-1 p-1 font-bold"
                                >
                                    Register
                                </Link>
                            </Typography>
                        </>
                    )}
                </div>
            </MobileNav>
        </MTNavbar>
    );
}

Navbar.propTypes = {
    brandName: PropTypes.string,
    action: PropTypes.node,
};

Navbar.displayName = "/src/widgets/layout/navbar.jsx";

export default Navbar;
