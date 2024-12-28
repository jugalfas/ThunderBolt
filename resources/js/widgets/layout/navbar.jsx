import React from "react";
import PropTypes from "prop-types";
import { Link } from "react-router-dom";
import {
    Navbar as MTNavbar,
    Typography,
    Button,
    IconButton,
    Collapse,
} from "@material-tailwind/react";
import { Bars3Icon, XMarkIcon } from "@heroicons/react/24/outline";

export function Navbar({ brandName = "Material Tailwind React", action }) {
    const [openNav, setOpenNav] = React.useState(false);

    React.useEffect(() => {
        window.addEventListener(
            "resize",
            () => window.innerWidth >= 960 && setOpenNav(false)
        );
    }, []);

    const navList = (
        <ul className="mb-4 mt-2 flex flex-col gap-2 text-inherit lg:mb-0 lg:mt-0 lg:flex-row lg:items-center lg:gap-6">
            {/* Add nav items here */}
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
                {/* <Link to="/">
                    <Typography className="mr-4 ml-2 cursor-pointer py-1.5 font-bold">
                        {brandName}
                    </Typography>
                </Link> */}
                <div className="hidden lg:block">{navList}</div>
                <div className="hidden gap-2 lg:flex">
                    <a
                        href="https://www.material-tailwind.com/blocks?ref=mtkr"
                        target="_blank"
                    >
                        <Button
                            variant="text"
                            size="sm"
                            color="white"
                            fullWidth
                        >
                            pro version
                        </Button>
                    </a>
                    {actionElement} {/* Use the safely cloned action element */}
                </div>
                <IconButton
                    variant="text"
                    size="sm"
                    color="white"
                    className="ml-auto text-inherit hover:bg-transparent focus:bg-transparent active:bg-transparent lg:hidden"
                    onClick={() => setOpenNav(!openNav)}
                >
                    {openNav ? (
                        <XMarkIcon strokeWidth={2} className="h-6 w-6" />
                    ) : (
                        <Bars3Icon strokeWidth={2} className="h-6 w-6" />
                    )}
                </IconButton>
            </div>
            <Collapse
                className="rounded-xl bg-white px-4 pt-2 pb-4 text-blue-gray-900"
                open={openNav}
            >
                <div className="container mx-auto">
                    {navList}
                    <a
                        href="https://www.material-tailwind.com/blocks/react?ref=mtkr"
                        target="_blank"
                        className="mb-2 block"
                    >
                        <Button variant="text" size="sm" fullWidth>
                            pro version
                        </Button>
                    </a>
                    {actionElement}
                </div>
            </Collapse>
        </MTNavbar>
    );
}

Navbar.propTypes = {
    brandName: PropTypes.string,
    action: PropTypes.node,
};

Navbar.displayName = "/src/widgets/layout/navbar.jsx";

export default Navbar;
